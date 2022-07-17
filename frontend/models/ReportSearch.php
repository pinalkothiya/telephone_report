<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\JobProcessing;

/**
 * ReportSearch represents the model for report.
 */
class ReportSearch extends JobProcessing
{
    /**
     * {@inheritdoc}
     */
    public $company_id;
    public $country_code_id;

    public function rules()
    {
        return [
            [['id', 'test_type_id', 'job_id', 'number_id', 'call_description_id','company_id','country_code_id'], 'integer'],
            [['call_start_time', 'call_connect_time', 'call_end_time', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function dailyReport($params)
    {
        $this->load($params);

        $where = ' Where 1=1 ';
        $bindParam = [];
        // filter according to company using number table
        if(!empty($this->company_id)){
            $where .= ' AND n.company_id = :company_id';
            $bindParam[':company_id'] = $this->company_id;
        }

        // filter according to country using number table
        if(!empty($this->country_code_id)){
            $where .= ' AND n.country_code_id = :country_code_id';
            $bindParam[':country_code_id'] = $this->country_code_id;
        }

        // filter according to date range
        if(!empty($this->created_on)){
            $where .= ' AND created_on > :from_date AND created_on < :to_date ';
            $dateArray = explode(' to ',$this->created_on);
            $fromDate = isset($dateArray[0]) ? $dateArray[0] : '';
            $toDate = isset($dateArray[1]) ? $dateArray[1] : '';
            $bindParam[':from_date'] = date('Y-m-d',strtotime($fromDate));
            $bindParam[':to_date'] = date('Y-m-d',strtotime($toDate));
        }
        
        $query = 'SELECT GROUP_CONCAT(DISTINCT c.name) AS company_name,
                        DATE(created_on) AS day_of_test,
                        cc.country_name,
                        COUNT(t.id) AS total_test,
                        SUM(IIF(Ifnull(t.call_description_id, 0) != 0, 1, 0)) AS total_failed_test,
                        ( ( 100 * SUM(IIF(IFNULL(t.call_description_id, 0) != 0, 0,1)) ) / COUNT(t.id) ) AS connection_score,
                        round(AVG(CASE
                            WHEN IFNULL(t.call_description_id, 0) = 0 
                                THEN ( ROUND(( Julianday(t.call_connect_time)- Julianday(t.call_start_time) ) * 86400) )
                            END)) AS pdd_score,
                        n.company_id,
                        n.country_code_id
                FROM   (SELECT `id`,`job_id`,`number_id` ,`call_start_time` ,`call_connect_time` ,`call_end_time` ,`call_description_id`,`created_on`
                        FROM   job_processing 
                        UNION
                        SELECT `id`,`job_id`,`number_id` ,`call_start_time` ,`call_connect_time` ,`call_end_time` ,`call_description_id`,`created_on`
                        FROM   job_processing_failover 
                        UNION
                        SELECT `id`,`job_id`,`number_id` ,`call_start_time` ,`call_connect_time` ,`call_end_time` ,`call_description_id`,`created_on`
                        FROM   job_processing_echo 
                        ) AS t
                        INNER JOIN number AS n
                                ON n.id = t.number_id
                        INNER JOIN company AS c
                                ON c.id = n.company_id
                        INNER JOIN country_code AS cc
                                ON cc.id = n.country_code_id
                        '.$where.'
                GROUP  BY day_of_test,
                        n.country_code_id,
                        n.company_id';
        


        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'params' => $bindParam,
            
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'company_name',
                    'day_of_test',
                    'country_name',
                    'total_test',
                    'total_failed_test',
                    'connection_score',
                    'pdd_score'
                ],
            ],
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function monthlyReport($params)
    {
        $this->load($params);

        $where = ' Where 1=1 ';
        $bindParam = [];
        // filter according to company
        if(!empty($this->company_id)){
            $where .= ' AND n.company_id = :company_id';
            $bindParam[':company_id'] = $this->company_id;
        }

        // filter according to country
        if(!empty($this->country_code_id)){
            $where .= ' AND n.country_code_id = :country_code_id';
            $bindParam[':country_code_id'] = $this->country_code_id;
        }

        // filter according to date range
        if(!empty($this->created_on)){
            $where .= ' AND created_on > :from_date AND created_on < :to_date ';
            $dateArray = explode(' to ',$this->created_on);
            $fromDate = isset($dateArray[0]) ? $dateArray[0] : '';
            $toDate = isset($dateArray[1]) ? $dateArray[1] : '';
            $bindParam[':from_date'] = date('Y-m-d',strtotime($fromDate));
            $bindParam[':to_date'] = date('Y-m-d',strtotime($toDate));
        }

        $query = 'SELECT GROUP_CONCAT(DISTINCT c.name) AS company_name,
                        strftime("%m-%Y", created_on) AS month_of_test,
                        cc.country_name,
                        COUNT(t.id) AS total_test,
                        SUM(IIF(Ifnull(t.call_description_id, 0) != 0, 1, 0)) AS total_failed_test, -- failed test which has call description
                        ( ( 100 * SUM(IIF(IFNULL(t.call_description_id, 0) != 0, 0,1)) ) / COUNT(t.id) ) AS connection_score,
                        round(AVG(CASE
                            WHEN IFNULL(t.call_description_id, 0) = 0 
                                THEN ( ROUND(( Julianday(t.call_connect_time)- Julianday(t.call_start_time) ) * 86400) )
                            END)) AS pdd_score,
                        n.company_id,
                        n.country_code_id,
                        ((case strftime("%m", created_on) 
                            when "01" then "January" 
                            when "02" then "Febuary" 
                            when "03" then "March" 
                            when "04" then "April" 
                            when "05" then "May" 
                            when "06" then "June" 
                            when "07" then "July" 
                            when "08" then "August" 
                            when "09" then "September"
                            when "10" then "October" 
                            when "11" then "November" 
                            when "12" then "December" else ""
                        END) || " " || strftime("%Y", created_on)) as month_name
                FROM   (SELECT `id`,`job_id`,`number_id` ,`call_start_time` ,`call_connect_time` ,`call_end_time` ,`call_description_id`,`created_on`
                        FROM   job_processing 
                        UNION
                        SELECT `id`,`job_id`,`number_id` ,`call_start_time` ,`call_connect_time` ,`call_end_time` ,`call_description_id`,`created_on`
                        FROM   job_processing_failover 
                        UNION
                        SELECT `id`,`job_id`,`number_id` ,`call_start_time` ,`call_connect_time` ,`call_end_time` ,`call_description_id`,`created_on`
                        FROM   job_processing_echo 
                        ) AS t
                        INNER JOIN number AS n
                                ON n.id = t.number_id
                        INNER JOIN company AS c
                                ON c.id = n.company_id
                        INNER JOIN country_code AS cc
                                ON cc.id = n.country_code_id
                        '.$where.'
                GROUP  BY month_of_test,
                        n.country_code_id,
                        n.company_id';
        


        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'params' => $bindParam,
            
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'company_name',
                    'month_of_test',
                    'country_name',
                    'total_test',
                    'total_failed_test',
                    'connection_score',
                    'pdd_score'
                ],
            ],
        ]);

        return $dataProvider;
    }
}
