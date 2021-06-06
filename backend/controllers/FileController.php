<?php


namespace backend\controllers;


use backend\models\form\FileUploadForm;
use backend\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class FileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN ,  User::ROLE_ADMIN_VIEW],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'terms' => ['GET'],
                    'delete-terms' => ['POST'],
                    'upload-terms' => ['POST']
                ],
            ],
        ];
    }

    public function actionIndex(){
        $termsAndConditionsFileEn = Yii::getAlias("@backend/web/uploads/") . "cnqa_terms_and_conditions_en.pdf";
        if(!file_exists($termsAndConditionsFileEn)) {
            $termsAndConditionsFileEn = null;
        }

        $termsAndConditionsFileFr = Yii::getAlias("@backend/web/uploads/") . "cnqa_terms_and_conditions_fr.pdf";
        if(!file_exists($termsAndConditionsFileFr)) {
            $termsAndConditionsFileFr = null;
        }

        $termsAndConditionsFilePt = Yii::getAlias("@backend/web/uploads/") . "cnqa_terms_and_conditions_pt.pdf";
        if(!file_exists($termsAndConditionsFilePt)) {
            $termsAndConditionsFilePt = null;
        }

        return $this->render('index', [
            'terms_en' =>$termsAndConditionsFileEn,
            'terms_fr' =>$termsAndConditionsFileFr,
            'terms_pt' =>$termsAndConditionsFilePt,
            'fileUploadForm' => new FileUploadForm()
        ]);
    }

    public function actionTerms($locale){
        $termsAndConditionsFile = Yii::getAlias("@backend/web/uploads/") . "cnqa_terms_and_conditions_".$locale.".pdf";
        if(!file_exists($termsAndConditionsFile)) {
            throw new NotFoundHttpException("Terms and conditions have not been uploaded yet");
        }
        return Yii::$app->response->sendFile($termsAndConditionsFile, "Terms and conditions", ['inline'=>true]);
    }

    public function actionDeleteTerms(){
        $termsAndConditionsFile = Yii::getAlias("@backend/web/uploads/") . "cnqa_terms_and_conditions.pdf";
        if(!file_exists($termsAndConditionsFile)) {
            throw new NotFoundHttpException("Terms and conditions have not been uploaded yet");
        }

        if (!unlink($termsAndConditionsFile)) {
            Yii::$app->session->setFlash('danger', Yii::t("app", "File deleted"));
        }
        else {
            Yii::$app->session->setFlash('success', Yii::t("app", "File deleted"));
        }
        return $this->redirect(['file/index']);
    }

    public function actionUploadTerms()
    {
        $model = new FileUploadForm();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

            $language =  "en";
            if($model->language == "fr"){
                $language = "fr";
            }

            if($model->language == "pt") {
                $language = "pt";
            }

            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload($language)) {
                Yii::$app->session->setFlash('success', Yii::t("app", "File uploaded"));
            }else{
                Yii::$app->session->setFlash('danger', Yii::t("app", "File not uploaded"));
            }
            return $this->redirect(['file/index']);
        }
    }
}