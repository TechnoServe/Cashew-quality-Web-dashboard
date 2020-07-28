<?php

namespace backend\controllers;

use backend\models\Company;
use backend\models\QarDetail;
use backend\models\User;
use common\helpers\CashewAppHelper;
use common\helpers\CashewAppHtmlHelper;
use Yii;
use backend\models\Qar;
use backend\models\search\QarSearch;
use backend\models\Site;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QarController implements the CRUD actions for Qar model.
 */
class QarController extends Controller
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
                        'roles' => ['@'],
                    ],

                    [
                        'allow' => true,
                        'roles' => [User::ROLE_INSTITUTION_ADMIN, User::ROLE_FIELD_TECH, User::ROLE_FIELD_FARMER, User::ROLE_FIELD_BUYER],
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
     * Lists all Qar models.
     * @return mixed
     */
    public function actionIndex($site = null)
    {


        $qarsInProgress = Qar::queryByCompany()->andWhere(["status"=>Qar::STATUS_IN_PROGRESS])->count();
        $qarsToBeDone = Qar::queryByCompany()->andWhere(["status"=>Qar::STATUS_TOBE_DONE])->count();
        $qarsCompleted = Qar::queryByCompany()->andWhere(["status"=>Qar::STATUS_COMPLETED])->count();
        $qarsCanceled = Qar::queryByCompany()->andWhere(["status"=>Qar::STATUS_CANCELED])->count();

        $searchModel = new QarSearch();

        if($site)
            $searchModel->site = $site;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'qarsInProgress' => $qarsInProgress,
            'qarsToBeDone' => $qarsToBeDone,
            'qarsCompleted' => $qarsCompleted,
            'qarsCanceled' => $qarsCanceled,
        ]);
    }

    /**
     * Displays a single Qar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        // Find Qar to be displayed
        $model = $this->findModel($id);

        // Find QAR measurements
        $measurements = QarDetail::findQarDetailsAsArray($model->id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'measurements' => CashewAppHelper::groupAssArrayBy($measurements, "sample_number")
        ]);
    }

    /**
     * Creates a new Qar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Qar();

        if ($model->load(Yii::$app->request->post())) {
            $model->purifyInput();

            if($model->validate() &&  $model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'showFieldTechSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_TECH,
            'showBuyerSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_BUYER,
            'showFarmerSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_FARMER,
        ]);
    }

    /**
     * Updates an existing Qar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->purifyInput();

            if($model->validate() &&  $model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'showFieldTechSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_TECH,
            'showBuyerSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_BUYER,
            'showFarmerSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_FARMER,
        ]);
    }

    /**
     * Deletes an existing Qar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Qar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Qar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Qar::queryByCompany()->andWhere(["id"=>$id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Export Data to CSV
     */
    public function actionExportCsv()
    {
        $query = Qar::queryByCompany();
        $filter = Yii::$app->request->post();

        //$filter['created_at_start'] ? $query->andFilterWhere(['created_at_start' => $filter['created_at_start']]) : null;
        //$filter['created_at_end'] ? $query->andWhere(['created_at_end' => $filter['created_at_end']]) : null;
        $filter['buyer'] ? $query->andWhere(['buyer' => $filter['buyer']]) : null;
        $filter['field_tech'] ? $query->andWhere(['field_tech' => $filter['field_tech']]) : null;
        $filter['farmer'] ? $query->andWhere(['farmer' => $filter['farmer']]) : null;
        $filter['initiator'] ? $query->andWhere(['initiator' => $filter['initiator']]) : null;
        $filter['site'] ? $query->andWhere(['site' => $filter['site']]) : null;
        $filter['status'] ? $query->andWhere(['status' => $filter['status']]) : null;

        $data = $query->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=qars' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Company'),
            Yii::t('app', 'Buyer'),
            Yii::t('app', 'Field Tech'),
            Yii::t('app', 'Farmer'),
            Yii::t('app', 'Initiator'),
            Yii::t('app', 'Site'),
            Yii::t('app', 'Estimated Volume of bags'),
            Yii::t('app', 'Estimated Volume of Stock (KG)'),
            Yii::t('app', 'Deadline'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'Created At')
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['company_id'] ? Company::findOne($row['company_id'])->name : '',
                $row['buyer'] ? User::findOne($row['buyer'])->getFullName() : '',
                $row['field_tech'] ? User::findOne($row['field_tech'])->getFullName() : '',
                $row['farmer'] ? User::findOne($row['farmer'])->getFullName() : '',
                $row['initiator'] ? Qar::getInitiatorByIndex($row['initiator']) : '',
                $row['site'] ? Site::findOne($row['site'])->site_name : '',
                $row['number_of_bags'],
                $row['volume_of_stock'],
                $row['deadline'],
                $row['status'] ? Qar::getQarStatusByIndex($row['status']) : '',
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
        $searchModel = new QarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $content = $this->renderPartial('_pdf', ['dataProvider' => $dataProvider]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@backend/web/css/pdf.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => 'QARs Report Title'],
            'methods' => [
                'SetHeader' => ['<div><img src="img/logo.png" width="100"></div>'],
                'SetFooter' => ['{PAGENO}'],
            ],
        ]);
        return $pdf->render();
    }
}
