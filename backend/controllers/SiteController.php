<?php

namespace backend\controllers;

use backend\models\form\ResetPasswordForm;
use backend\models\form\PasswordResetRequestForm;
use backend\models\Qar;
use backend\models\Site;
use backend\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\db\Expression;

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
                            'request-password-reset',
                            'reset-password',
                            'verify-email',
                        ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'logout',
                            'error',
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
    public function actionIndex($site = null)
    {
        // QARs
        $qarsInProgress = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_IN_PROGRESS])->count();
        $qarsToBeDone = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_TOBE_DONE])->count();
        $qarsCompleted = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_COMPLETED])->count();
        $qarsCanceled = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_CANCELED])->count();

        // Sites
        $totalSites =  Site::queryByCompany()->count();
        $totalSitesWithoutImages =  Site::queryByCompany()->andWhere(["or", ["image" => ""], ["image" => null]])->count();
        $totalSitesWithoutSiteLocation =  Site::queryByCompany()->andWhere(["or", ["map_location" => ""], ["map_location" => null]])->count();

        // Users
        $totalUsers = User::queryByCompany()->count();
        $totalFieldTech = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_TECH])->count();
        $totalBuyer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_BUYER])->count();
        $totalFarmer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_FARMER])->count();

        // Group QARs weekly
        $weeklyQars = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')])->count();
        $weeklyQarsToBeDone = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')])->andWhere(["status" => Qar::STATUS_TOBE_DONE])->count();
        $weeklyQarsInProgress = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')])->andWhere(["status" => Qar::STATUS_IN_PROGRESS])->count();
        $weeklyQarsCompleted = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')])->andWhere(["status" => Qar::STATUS_COMPLETED])->count();

        // Group QARs monthly
        $monthlyQars = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')])->count();
        $monthlyQarsToBeDone = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')])->andWhere(["status" => Qar::STATUS_TOBE_DONE])->count();
        $monthlyQarsInProgress = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')])->andWhere(["status" => Qar::STATUS_IN_PROGRESS])->count();
        $monthlyQarsCompleted = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')])->andWhere(["status" => Qar::STATUS_COMPLETED])->count();

        // Group QARs quarterly
        $monthlyQars = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 3 MONTH)')])->count();
        $monthlyQarsToBeDone = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 3 MONTH)')])->andWhere(["status" => Qar::STATUS_TOBE_DONE])->count();
        $monthlyQarsInProgress = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 3 MONTH)')])->andWhere(["status" => Qar::STATUS_IN_PROGRESS])->count();
        $monthlyQarsCompleted = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 3 MONTH)')])->andWhere(["status" => Qar::STATUS_COMPLETED])->count();


        // Group QARs yearly
        $yearlyQars = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 YEAR)')])->count();
        $yearlyQarsToBeDone = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 YEAR)')])->andWhere(["status" => Qar::STATUS_TOBE_DONE])->count();
        $yearlyQarsInProgress = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 YEAR)')])->andWhere(["status" => Qar::STATUS_IN_PROGRESS])->count();
        $yearlyQarsCompleted = Qar::queryByCompany()->andWhere(['>', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 YEAR)')])->andWhere(["status" => Qar::STATUS_COMPLETED])->count();

        //var_dump($dailyQars);
        //die();

        return $this->render('index', [
            'qarsInProgress' => $qarsInProgress,
            'qarsToBeDone' => $qarsToBeDone,
            'qarsCompleted' => $qarsCompleted,
            'qarsCanceled' => $qarsCanceled,
            'totalSites' => $totalSites,
            'totalSitesWithoutImages' => $totalSitesWithoutImages,
            'totalSitesWithoutSiteLocation' => $totalSitesWithoutSiteLocation,
            'totalUsers' => $totalUsers,
            'totalFieldTech' => $totalFieldTech,
            'totalBuyer' => $totalBuyer,
            'totalFarmer' => $totalFarmer
        ]);
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
