<?php

namespace backend\controllers;

use backend\models\form\ResetPasswordForm;
use backend\models\form\PasswordResetRequestForm;
use backend\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => [
                            'login',
                            'error',
                            'request-password-reset',
                            'reset-password',
                            'verify-email',
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'switch-user-language',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        $this->layout = "login";
        if ( ! Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = "login";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success',
                    'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('danger',
                    'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = "login";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success',
                'New password saved successfully.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /**
     * Handle logout requests
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Switch user language
     *
     * @param $language
     *
     * @return \yii\web\Response
     */
    public function actionSwitchUserLanguage($language)
    {

        $allowedLanguages = User::getLanguagesDropDownList();
        if (isset($allowedLanguages[$language])) {
            Yii::$app->language = $language;
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Set new password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        $this->layout = "login";
    
        $model = User::findOne(["verification_token" => $token, "status"=> User::STATUS_WAITING_FOR_ACTIVATION]);

        if(!$model){
            Yii::$app->session->setFlash("danger", Yii::t("app", "Invalid verification link"));
            return $this->redirect(["site/login"]);
        }
        
        $model->status = User::STATUS_ACTIVE;
        $model->verification_token = null;

        if($model->save(false)){
            Yii::$app->session->setFlash("success", Yii::t("app", "Account activated successfully, Please consider changing your password!"));
        } else {
            Yii::$app->session->setFlash("success", Yii::t("app", "Could not activate account"));
        }

        return $this->redirect(["site/login"]);
    }
}
