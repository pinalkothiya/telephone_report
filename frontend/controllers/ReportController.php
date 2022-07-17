<?php

namespace frontend\controllers;

use app\models\JobProcessing;
use app\models\ReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Company;
use app\models\CountryCode;

/**
 * ReportController implements the CRUD actions for JobProcessing model.
 */
class ReportController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Daily report based on day and country.
     *
     * @return string
     */
    public function actionDailyReport()
    {
        // get report data
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->dailyReport($this->request->queryParams);

        // get company name list for filter
        $companyModel = new Company();
        $companyList = $companyModel->getCompanyList();

        // get country list for country filter
        $countryModel = new CountryCode();
        $countryList = $countryModel->getCountryList();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'companyList' => $companyList,
            'countryList' => $countryList
        ]);
    }

    /**
     * Monthly report based on month and country.
     *
     * @return string
     */
    public function actionMonthlyReport()
    {
        // get report data
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->monthlyReport($this->request->queryParams);

        // get company name list for filter
        $companyModel = new Company();
        $companyList = $companyModel->getCompanyList();

        // get country list for country filter
        $countryModel = new CountryCode();
        $countryList = $countryModel->getCountryList();
        
        return $this->render('monthly_report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'companyList' => $companyList,
            'countryList' => $countryList
        ]);
    }
}
