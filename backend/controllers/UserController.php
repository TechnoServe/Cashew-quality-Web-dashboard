<?php

namespace backend\controllers;

use backend\models\Company;
use backend\models\Report;
use backend\models\search\UserEquipmentSearch;
use common\helper\OmsHelper;
use common\helpers\CashewAppHelper;
use Yii;
use backend\models\User;
use backend\models\search\UserSearch;
use InvalidArgumentException;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'actions' => ['view', 'export-csv', 'export-pdf'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['index', 'export-csv', 'export-pdf'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_ADMIN_VIEW, User::ROLE_INSTITUTION_ADMIN, User::ROLE_INSTITUTION_ADMIN_VIEW],
                    ],

                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_INSTITUTION_ADMIN],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $totalUsers = User::queryByCompany()->count();
        $totalFieldTech = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_TECH])->count();
        $totalBuyer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_BUYER])->count();
        $totalFarmer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_FARMER])->count();

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUsers' => $totalUsers,
            'totalFieldTech' => $totalFieldTech,
            'totalBuyer' => $totalBuyer,
            'totalFarmer' => $totalFarmer
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new UserEquipmentSearch();
        $searchModel->id_user = $model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 30, false);
        
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new User();

        $model->scenario = "create";

        if ($model->load(Yii::$app->request->post())) {

            $model->password_hash = Yii::$app->security->generatePasswordHash($model->pass);

            $model->generateAuthKey();

            $model->purifyInput();

            $plain_pass = $model->pass;

            $transaction = Yii::$app->db->beginTransaction();


            if ($model->validate() && $model->save()) {
                if ($model->sendEmail($plain_pass)) {
                    Yii::$app->session->setFlash('success', Yii::t("app", "Email sent to newly created user."));

                    $transaction ->commit();

                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction ->rollBack();
                    Yii::$app->session->setFlash('danger',
                        Yii::t("app", "Sorry, we are unable to send an email to the newly created user."));
                }
            }
            $transaction ->rollBack();
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if(!empty($model->pass)){
                $model->setPassword($model->pass);
            }

            $model->purifyInput();

            if ($model->validate() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]); 
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if ($model->status == User::STATUS_ACTIVE) {
            $model->status = User::STATUS_INACTIVE;
        } else {
            $model->status = User::STATUS_ACTIVE;
        }
        $model->save(0);
        return $this->redirect(['index']);

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::queryByCompany()->andWhere(["id" => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Export Data to CSV
     */
    public function actionExportCsv()
    {
        $query = User::queryByCompany();
        $filter = Yii::$app->request->getQueryParams();

        $filter['username'] ? $query->andFilterWhere(['like', 'username' , $filter['username']]) : null;
        $filter['first_name'] ? $query->andFilterWhere(['like', 'first_name' , $filter['first_name']]) : null;
        $filter['last_name'] ? $query->andFilterWhere(['like', 'last_name' , $filter['last_name']]) : null;
        $filter['role'] ? $query->andFilterWhere(['role' => $filter['role']]) : null;
        $filter['status'] ? $query->andFilterWhere(['status' => $filter['status']]) : null;
        $filter['company_id'] ? $query->andFilterWhere(['status' => $filter['company_id']]) : null;


        $data = $query->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=users'.date('Y/m/d h:m:s').'.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Username'),
            Yii::t('app', 'First Name'),
            Yii::t('app', 'Middle Name'),
            Yii::t('app', 'Last Name'),
            Yii::t('app', 'Company'),
            Yii::t('app', 'Email'),
            Yii::t('app', 'Phone'),
            Yii::t('app', 'Address'),
            Yii::t('app', 'Preferred Language'),
            Yii::t('app', 'Role'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'Created At')
        ]);

        foreach($data as $row)
        {
            fputcsv($output, [
                $row['username'],
                $row['first_name'],
                $row['middle_name'],
                $row['last_name'],
                $row['company_id'] ? Company::findOne($row['company_id'])->name : '',
                $row['email'],
                $row['phone'],
                $row['address'],
                $row['language'] ? User::getLanguageByIndex($row['language']) : '',
                $row['role'] ? User::getUserRoleByIndex($row['role']) : '',
                $row['status'] ? User::getUserStatusByIndex($row['status']) : '',
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
        $query = User::queryByCompany();
        $filter = Yii::$app->request->getQueryParams();

        $filter['username'] ? $query->andFilterWhere(['like', 'username' , $filter['username']]) : null;
        $filter['first_name'] ? $query->andFilterWhere(['like', 'first_name' , $filter['first_name']]) : null;
        $filter['last_name'] ? $query->andFilterWhere(['like', 'last_name' , $filter['last_name']]) : null;
        $filter['role'] ? $query->andFilterWhere(['role' => $filter['role']]) : null;
        $filter['status'] ? $query->andFilterWhere(['status' => $filter['status']]) : null;
        $filter['company_id'] ? $query->andFilterWhere(['status' => $filter['company_id']]) : null;



        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return CashewAppHelper::renderPDF($this->renderPartial('_pdf', ['models' => $query->all(), 'showCompany' => Yii::$app->user->identity->company_id  == null]), Pdf::FORMAT_A4, Pdf::ORIENT_PORTRAIT, null, ['marginTop' => '15px','marginLeft' => '10px','marginRight' => '10px','marginBottom' => '15px'], "users_" .date('Y_m_d-H_i_s', strtotime('now')). ".pdf");
    }
}
