<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\JobProcessingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monthly Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-processing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php Pjax::begin([
        'id' => 'monthly-report', 
        'timeout' => false,
        'enablePushState' => false, 
        'enableReplaceState' => false,
    ]); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'company_name',
                'label' => 'Company',
                'filter' => Html::activeDropDownList($searchModel, 'company_id', $companyList,['class'=>'form-control','prompt' => 'Select Company']),
                
            ],
            [
                'attribute' => 'month_of_test',
                'label' => 'Month',
                'filter' => DateRangePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'created_on',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>[
                            'format'=>'d-M-Y',
                            'separator'=>' to ',
                        ],
                        'opens'=>'left'
                    ]
                ]),
                'value' => function ($data) {
                    return $data['month_name'];
                }
            ],
            [
                'attribute' => 'country_name',
                'label' => 'Country',
                'filter' => Html::activeDropDownList($searchModel, 'country_code_id', $countryList,['class'=>'form-control','prompt' => 'Select Country']),
            ],
            [
                'attribute' => 'total_test',
                'label' => 'Number of tests',
            ],
            [
                'attribute' => 'total_failed_test',
                'label' => 'Number of fails',
            ],
            [
                'attribute' => 'connection_score',
                'filter' => FALSE,
                'value' => function ($data) {
                    return $data["connection_score"].'%';
                }
            ],
            [
                'label' => 'PDD Score',
                'attribute' => 'pdd_score',
                'filter' => FALSE,
                'value' => function ($data) {
                    return $data["pdd_score"];
                }
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
