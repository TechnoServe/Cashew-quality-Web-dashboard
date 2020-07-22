<?php

namespace backend\controllers;

use backend\models\User;
use Yii;
use backend\models\UserEquipment;
use backend\models\search\UserEquipmentSearch;
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
                        'actions' => ['index','view'],
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

        if ($model->load(Yii::$app->request->post())) {

            // get the instance of the uploaded file
            $model->image = UploadedFile::getInstance($model, 'image');

            if($model->uploadImage()){ // If image upload is done successfully

                $model->purifyInput();

                if($model->save(false))
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

        if ($model->load(Yii::$app->request->post())) {
            // get the instance of the uploaded file
            $model->image = UploadedFile::getInstance($model, 'image');

            if($model->uploadImage()){ // If image upload is done successfully

                $model->purifyInput();

                if( $model->save(false))
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
}
