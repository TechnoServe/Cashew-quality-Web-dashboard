<?php

namespace backend\controllers;

use backend\models\Company;
use backend\models\User;
use common\helpers\CashewAppHelper;
use Yii;
use backend\models\UserEquipment;
use backend\models\search\UserEquipmentSearch;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserEquipmentController implements the CRUD actions for UserEquipment model.
 */
class UserEquipmentController extends Controller
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
                        'roles' => [User::ROLE_INSTITUTION_ADMIN, User::ROLE_FIELD_TECH, User::ROLE_ADMIN, User::ROLE_ADMIN_VIEW],
                    ],

                    [
                        'allow' => true,
                        'roles' => [User::ROLE_INSTITUTION_ADMIN, User::ROLE_FIELD_TECH],
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
     * Lists all UserEquipment models.
     * @return mixed
     */
    public function actionIndex($user_id = null)
    {
        $searchModel = new UserEquipmentSearch();

        if(!empty($user_id))
            $searchModel->id_user = $user_id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserEquipment model.
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
     * Creates a new UserEquipment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserEquipment();

        if(Yii::$app->user->identity->role == User::ROLE_FIELD_TECH){
            $model->id_user = Yii::$app->user->getId();
        }

        if ($model->load(Yii::$app->request->post())) {

            // get the instance of the uploaded file
            $model->image = UploadedFile::getInstance($model, 'image');

            if($model->uploadImage()){ // If image upload is done successfully

                $model->purifyInput();

                if($model->validate(["model", "name"]) && $model->save(false))
                    return $this->redirect(['view', 'id' => $model->id]);
            };
        }

        return $this->render('create', [
            'model' => $model,
            'showFieldTechSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_TECH,
        ]);
        
    }

    /**
     * Updates an existing UserEquipment model.
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
            $model->image = UploadedFile::getInstance($model, 'image');

            if($model->uploadImage()){ // If image upload is done successfully

                $model->purifyInput();

                if($model->save(false))
                    return $this->redirect(['view', 'id' => $model->id]);
            };
        }

        return $this->render('update', [
            'model' => $model,
            'showFieldTechSelectorOnForm' => Yii::$app->user->identity->role != User::ROLE_FIELD_TECH,
        ]);
    }

    /**
     * Deletes an existing UserEquipment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model  = $this->findModel($id);
        $model->deleteAttachments();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserEquipment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserEquipment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserEquipment::queryByCompany()->andWhere(["id" => $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Export Data to CSV
     */
    public function actionExportCsv()
    {
        $query = UserEquipment::queryByCompany();
        $filter = Yii::$app->request->getQueryParams();

        $filter['id_user'] ? $query->andFilterWhere(['id_user' => $filter['id_user']]) : null;
        $filter['brand'] ? $query->andFilterWhere(['like', 'brand' ,  $filter['brand']]) : null;
        $filter['model'] ? $query->andFilterWhere(['like', 'model' , $filter['model']]) : null;
        $filter['name'] ? $query->andFilterWhere(['like', 'name' , $filter['name']]) : null;
        $filter['company_id'] ? $query->andFilterWhere(['company_id' => $filter['company_id']]) : null;

        $data = $query->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=user-equipments' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'User'),
            Yii::t('app', 'Company'),
            Yii::t('app', 'Brand'),
            Yii::t('app', 'Model'),
            Yii::t('app', 'Name'),
            Yii::t('app', 'Manufacturing Date'),
            Yii::t('app', 'Created At')
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['id_user'] ? User::findOne($row['id_user'])->getFullName() : '',
                $row['company_id'] ? Company::findOne($row['company_id'])->name : '',
                $row['brand'],
                $row['model'],
                $row['name'],
                $row['manufacturing_date'],
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
        $query = UserEquipment::queryByCompany();
        $filter = Yii::$app->request->getQueryParams();

        $filter['id_user'] ? $query->andFilterWhere(['id_user' => $filter['id_user']]) : null;
        $filter['brand'] ? $query->andFilterWhere(['like', 'brand' ,  $filter['brand']]) : null;
        $filter['model'] ? $query->andFilterWhere(['like', 'model' , $filter['model']]) : null;
        $filter['name'] ? $query->andFilterWhere(['like', 'name' , $filter['name']]) : null;
        $filter['company_id'] ? $query->andFilterWhere(['company_id' => $filter['company_id']]) : null;

        return CashewAppHelper::renderPDF($this->renderPartial('_pdf', ['models' =>  $query->all(), 'showCompany' => Yii::$app->user->identity->company_id  == null]), Pdf::FORMAT_A4, Pdf::ORIENT_PORTRAIT, null, ['marginTop' => '15px','marginLeft' => '10px','marginRight' => '10px','marginBottom' => '15px'], "equipments_" .date('Y_m_d-H_i_s', strtotime('now')). ".pdf");
    }
}
