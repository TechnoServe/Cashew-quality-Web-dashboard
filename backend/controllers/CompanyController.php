<?php

namespace backend\controllers;

use backend\models\User;
use common\helpers\CashewAppHelper;
use Yii;
use backend\models\Company;
use backend\models\Qar;
use backend\models\search\CompanySearch;
use backend\models\Site;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
                        'actions' => ['index', 'view', 'export-csv', 'export-pdf'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN ,  User::ROLE_ADMIN_VIEW],
                    ],

                    [
                        //'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'restore' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // get the instance of the uploaded file
            $model->logoUploaded = UploadedFile::getInstance($model, 'logoUploaded');

            if($model->uploadLogo()) {
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            // get the instance of the uploaded file
            $model->logoUploaded = UploadedFile::getInstance($model, 'logoUploaded');

            if($model->uploadLogo()){ // If image upload is done successfully
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);

            };
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Company model.
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

        if ($model->status == Company::STATUS_INACTIVE) {
            Yii::$app->session->setFlash("danger", Yii::t("app", "Company already inactive"));
            return $this->redirect(["company/view", "id" => $model->id]);
        }

        $model->status = Company::STATUS_INACTIVE;

        $model->save(0);

        Yii::$app->session->setFlash("success", Yii::t("app", "Company deactivated successfully"));

        return $this->redirect(['company/view', "id"=>$model->id]);
    }



    public function actionRestore($id)
    {

        $model = $this->findModel($id);

        if ($model->status == Company::STATUS_ACTIVE) {
            Yii::$app->session->setFlash("danger", Yii::t("app", "Company already active"));
            return $this->redirect(["company/view", "id" => $model->id]);
        }

        $model->status = Company::STATUS_ACTIVE;

        $model->save(0);

        Yii::$app->session->setFlash("success", Yii::t("app", "Company re-activated successfully"));

        return $this->redirect(['company/view', "id"=>$model->id]);

    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Export Data to CSV
     */
    public function actionExportCsv()
    {
        $query = Company::find();
        $filter = Yii::$app->request->getQueryParams();

        $filter['name'] ? $query->andFilterWhere(['like', 'name' , $filter['name']]) : null;
        $filter['city'] ? $query->andFilterWhere(['like', 'city' ,  $filter['city']]) : null;
        $filter['address'] ? $query->andFilterWhere(['like', 'address' ,  $filter['address']]) : null;
        $filter['primary_contact'] ? $query->andFilterWhere(['like', 'primary_contact' , $filter['primary_contact']]) : null;
        $filter['status'] ? $query->andFilterWhere(['status' => $filter['status']]) : null;

        $data = $query->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=companies' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Name'),
            Yii::t('app', 'City'),
            Yii::t('app', 'Address'),
            Yii::t('app', 'Primary Contact'),
            Yii::t('app', 'Primary Phone'),
            Yii::t('app', 'Primary Email'),
            Yii::t('app', 'Fax Number'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'Top Admin Users'),
            Yii::t('app', 'Top Admin View Users'),
            Yii::t('app', 'Institution Admin Users'),
            Yii::t('app', 'Institution Admin View Users'),
            Yii::t('app', 'Field Tech Users'),
            Yii::t('app', 'Buyer Users'),
            Yii::t('app', 'Farmer Users'),
            Yii::t('app', 'Qars To be Done'),
            Yii::t('app', 'Qars In Progress'),
            Yii::t('app', 'Qars Completed'),
            Yii::t('app', 'Qars Canceled'),
            Yii::t('app', 'Sites'),
            Yii::t('app', 'Description'),
            Yii::t('app', 'Created At')
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['name'],
                $row['city'],
                $row['address'],
                $row['primary_contact'],
                $row['primary_phone'],
                $row['primary_email'],
                $row['fax_number'],
                $row['status'] ? Company::getCompanyStatusByIndex($row['status']) : '',
                $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role"=>User::ROLE_ADMIN])->count() : '',
                $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_ADMIN_VIEW])->count() : '',
                $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_INSTITUTION_ADMIN])->count() : '',
                $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_INSTITUTION_ADMIN_VIEW])->count() : '',
                $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_FIELD_TECH])->count() : '',
                $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_FIELD_BUYER])->count() : '',
                $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_FIELD_FARMER])->count() : '',                
                $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status"=> Qar::STATUS_TOBE_DONE])->count() : '',
                $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status" => Qar::STATUS_IN_PROGRESS])->count() : '',
                $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status"=> Qar::STATUS_COMPLETED])->count() : '',
                $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status"=> Qar::STATUS_CANCELED])->count() : '',
                $row['id'] ? Site::find()->andWhere(["company_id" => $row['id']])->count() : '',
                $row['description'],
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
        $query = Company::find();
        $filter = Yii::$app->request->getQueryParams();

        $filter['name'] ? $query->andFilterWhere(['name' => $filter['name']]) : null;
        $filter['city'] ? $query->andWhere(['city' => $filter['city']]) : null;
        $filter['address'] ? $query->andWhere(['address' => $filter['address']]) : null;
        $filter['primary_contact'] ? $query->andWhere(['primary_contact' => $filter['primary_contact']]) : null;
        $filter['status'] ? $query->andWhere(['status' => $filter['status']]) : null;

        return CashewAppHelper::renderPDF($this->renderPartial('_pdf', ['models' => $query->all()]), Pdf::FORMAT_A4, Pdf::ORIENT_LANDSCAPE, null, ['marginTop' => '15px','marginLeft' => '10px','marginRight' => '10px','marginBottom' => '15px'], "companies_" .date('Y_m_d-H_i_s', strtotime('now')). ".pdf");
    }
}
