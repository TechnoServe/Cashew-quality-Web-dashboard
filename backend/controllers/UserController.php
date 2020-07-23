<?php

namespace backend\controllers;

use backend\models\Company;
use backend\models\search\UserEquipmentSearch;
use Yii;
use backend\models\User;
use backend\models\search\UserSearch;
use InvalidArgumentException;
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
                        'actions' => ['view', 'export-csv'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['index', 'export-csv'],
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
                    Yii::$app->session->setFlash('success', 'Email sent to newly created user.');

                    $transaction ->commit();

                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction ->rollBack();
                    Yii::$app->session->setFlash('danger',
                        'Sorry, we are unable to send an email to the newly created user.');
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
        $query = User::find();
        $filter = Yii::$app->request->post();

        $filter['username'] ? $query->andFilterWhere(['username' => $filter['username']]) : null;
        $filter['first_name'] ? $query->andWhere(['first_name' => $filter['first_name']]) : null;
        $filter['last_name'] ? $query->andWhere(['last_name' => $filter['last_name']]) : null;
        $filter['role'] ? $query->andWhere(['role' => $filter['role']]) : null;
        $filter['status'] ? $query->andWhere(['status' => $filter['status']]) : null;

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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $html = $this->renderPartial('_pdf', ['dataProvider' => $dataProvider]);
        $mpdf = new \mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;
    }
}
