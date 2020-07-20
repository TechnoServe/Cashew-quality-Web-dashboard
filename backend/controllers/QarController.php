<?php

namespace backend\controllers;

use backend\models\User;
use common\helpers\CashewAppHtmlHelper;
use Yii;
use backend\models\Qar;
use backend\models\search\QarSearch;
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
                        'actions' => ['index','view'],
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
}
