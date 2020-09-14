<?php

namespace backend\controllers;

use backend\models\Company;
use backend\models\Qar;
use backend\models\search\QarSearch;
use backend\models\User;
use common\helpers\CashewAppHelper;
use Yii;
use backend\models\Site;
use backend\models\search\SiteSearch;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SitesController implements the CRUD actions for Site model.
 */
class SitesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view', 'export-csv', 'export-pdf'],
                        'allow' => true,
                        'roles' => [User::ROLE_INSTITUTION_ADMIN, User::ROLE_ADMIN, User::ROLE_ADMIN_VIEW],
                    ],

                    [
                        'allow' => true,
                        'roles' => [User::ROLE_INSTITUTION_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Site models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SiteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $totalSites =  Site::queryByCompany()->count();
        $totalSitesWithoutImages =  Site::queryByCompany()->andWhere([ "or", ["image"=> ""],["image"=> null]])->count();
        $totalSitesWithoutSiteLocation =  Site::queryByCompany()->andWhere([ "or", ["map_location"=> ""],["map_location"=> null]])->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalSites'=>$totalSites,
            'totalSitesWithoutImages'=>$totalSitesWithoutImages,
            'totalSitesWithoutSiteLocation'=>$totalSitesWithoutSiteLocation
        ]);
    }

    /**
     * Displays a single Site model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $startDate = null, $endDate = null, $predefinedPeriod = null)
    {

        $model = $this->findModel($id);

        $model->getLatitudeAndLongitudeFromMapLocation();

        $searchModel = new QarSearch();
        $searchModel->site = $model->id;
        $qarListDataProvider = $searchModel->search(Yii::$app->request->queryParams, 20, false);


        list($startDate, $endDate)  = CashewAppHelper::calculateStartDateAndEndDateForAnalytics($startDate, $endDate, $predefinedPeriod);


        // chart
        $period = CashewAppHelper::getDatePeriodToFetch($startDate, $endDate);
        if (empty($period))
            return $this->redirect(["/"]);

        $categories = array_map( function ($date){ return $date["generic"];}, $period);

        $series = [];

        // QARs To-Be Done
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "To Be Done"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 1, $model->id),
                'color' => "#ffb300"
            ]
        );

        // QARs In Progress
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "In Progress"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 2, $model->id),
                'color' => "#03a9f4"
            ]
        );

        // QARs Completed
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "Completed"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 3, $model->id),
                'color' => "#26a69a"
            ]
        );

        // QARs Average
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Average QAR"),
                'data' => Qar::getAverageQarByTimePeriod($period, $model->id),
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white'
                ]
            ]
        );

        //Pie chart
        array_push($series,
            [
                'type' => 'pie',
                'name' => 'Total QARs',
                'title' => false,
                'data' => [
                    [
                        'name' => Yii::t("app", "To Be Done") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[0]['data']),
                        'color' => "#ffb300"
                    ],
                    [
                        'name' => Yii::t("app", "In Progress") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[1]['data']),
                        'color' => "#03a9f4"
                    ],
                    [
                        'name' => Yii::t("app", "Completed") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[2]['data']),
                        'color' => "#26a69a"
                    ],
                ],
                'center' => [30, 30],
                'size' => 100,
                'showInLegend' => true,
                'dataLabels' => [
                    'enabled' => false
                ]
            ]
        );

        return $this->render('view', [
            'model' => $model,
            'qarListDataProvider' => $qarListDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'predefinedPeriod' => $predefinedPeriod,
            'chartSeries' => $series,
            'categories' => $categories
        ]);
    }

    /**
     * Creates a new Site model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Site();

        if ($model->load(Yii::$app->request->post())) {

            // get the instance of the uploaded file
            $model->siteImage = UploadedFile::getInstance($model, 'siteImage');

            $model->purifyInput();

            if($model->validate() && $model->uploadImage()){
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model->getErrors());
                die();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Site model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // get the instance of the uploaded file
            $model->siteImage = UploadedFile::getInstance($model, 'siteImage');

            $model->purifyInput();

            if($model->validate() && $model->uploadImage()) {
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Site model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteAttachments();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Site model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Site the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Site::queryByCompany()->andWhere(["id" => $id])->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Export Data to CSV
     */
    public function actionExportCsv()
    {
        $query = Site::queryByCompany();
        $filter = Yii::$app->request->getQueryParams();

        $filter['site_name'] ? $query->andFilterWhere(['like', 'site_name' ,  $filter['site_name']]) : null;
        $filter['site_location'] ? $query->andFilterWhere(['like', 'site_location' => $filter['site_location']]) : null;
        $filter['company_id'] ? $query->andFilterWhere(['company_id' => $filter['company_id']]) : null;

        $data = $query->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=sites' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Company'),
            Yii::t('app', 'Site Name'),
            Yii::t('app', 'Site Location'),
            Yii::t('app', 'Map Coordinates'),
            Yii::t('app', 'Average KOR'),
            Yii::t('app', 'Created At')
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['company_id'] ? Company::findOne($row['company_id'])->name : '',
                $row['site_name'],
                $row['site_location'],
                $row['map_location'],
                Qar::getAverageKorBySite($row['id']),
                $row['created_at']
            ]);
        }
        fclose($output);
        exit();
    }

    /**
     * Export Data to PDF
     */
    public function actionExportPdf()
    {
        $query = Site::queryByCompany();
        $filter = Yii::$app->request->getQueryParams();
        $filter['site_name'] ? $query->andFilterWhere(['like', 'site_name' ,  $filter['site_name']]) : null;
        $filter['site_location'] ? $query->andFilterWhere(['like', 'site_location' ,  $filter['site_location']]) : null;
        $filter['company_id'] ? $query->andFilterWhere(['company_id' => $filter['company_id']]) : null;

        return CashewAppHelper::renderPDF($this->renderPartial('_pdf', ['models' => $query->all(), 'showCompany' => Yii::$app->user->identity->company_id  == null]), Pdf::FORMAT_A4, Pdf::ORIENT_PORTRAIT, '.kv-heading-1{font-size:18px}', ['marginTop' => '15px','marginLeft' => '10px','marginRight' => '10px','marginBottom' => '15px'], "sites_" .date('Y_m_d-H_i_s', strtotime('now')). ".pdf");
    }
}
