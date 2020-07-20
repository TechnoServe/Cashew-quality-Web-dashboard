<?php

namespace backend\controllers;

use backend\models\search\QarSearch;
use backend\models\User;
use Yii;
use backend\models\Site;
use backend\models\search\SiteSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
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
                        'actions' => ['index','view'],
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
    public function actionView($id)
    {

        $model = $this->findModel($id);

        $model->getLatitudeAndLongitudeFromMapLocation();

        $searchModel = new QarSearch();
        $searchModel->site = $model->id;
        $qarListDataProvider = $searchModel->search(Yii::$app->request->queryParams, 20, false);

        return $this->render('view', [
            'model' => $model,
            'qarListDataProvider' => $qarListDataProvider
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
}
