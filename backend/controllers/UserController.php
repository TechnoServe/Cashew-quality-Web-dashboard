<?php

namespace backend\controllers;

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
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['index'],
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
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

            if ($model->validate() && $model->save()) {
                if ($model->sendEmail()) {
                    Yii::$app->session->setFlash('success',
                        'Email sent to newly created user.');

                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('danger',
                        'Sorry, we are unable to send an email to the newly created user.');
                }
            }

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
}
