<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', ['terms' => Yii::$app->urlManager->createAbsoluteUrl(["site/terms"])]);
    }

    public function actionTerms($locale = null){

        if(!$locale || !($locale == "fr" || $locale == "pt")){
            $locale = "en";
        }

        $termsAndConditionsFile = Yii::getAlias("@backend/web/uploads/") . "cnqa_terms_and_conditions_".$locale.".pdf";
        if(!file_exists($termsAndConditionsFile)) {
            throw new NotFoundHttpException("Terms and conditions have not been uploaded yet");
        }
        return Yii::$app->response->sendFile($termsAndConditionsFile, "Terms and conditions", ['inline'=>true]);
    }

    public function actionPrivacy($locale = null){

        if(!$locale || !($locale == "fr" || $locale == "pt")){
            $locale = "en";
        }

        $termsAndConditionsFile = Yii::getAlias("@backend/web/uploads/") . "cnqa_privacy_policy_".$locale.".pdf";
        if(!file_exists($termsAndConditionsFile)) {
            throw new NotFoundHttpException("Privacy policy has not been uploaded yet");
        }
        return Yii::$app->response->sendFile($termsAndConditionsFile, "Privacy policy", ['inline'=>true]);
    }
}
