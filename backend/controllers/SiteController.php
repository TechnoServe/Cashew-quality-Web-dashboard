<?php

namespace backend\controllers;
use backend\helpers\SiteHelper;
use backend\models\form\ResetPasswordForm;
use backend\models\form\PasswordResetRequestForm;
use backend\models\Qar;
use backend\models\Site;
use backend\models\User;
use common\helpers\CashewAppHelper;
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
    const REQUEST_ORIGIN_MOBILE = "mobile";
    const REQUEST_ORIGIN_WEB = "web";
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
                            'verify-email'
                        ],
                        'allow' => true
                    ],
                    [
                        'actions' => [
                            'logout',
                            'error',
                            'index',
                            'switch-user-language'
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
    public function actionIndex($startDate = null, $endDate = null, $predefinedPeriod = null, $country_code = null)
    {

        list($startDate, $endDate)  = CashewAppHelper::calculateStartDateAndEndDateForAnalytics($startDate, $endDate, $predefinedPeriod);

        // QARs
        $qarsInProgress = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_IN_PROGRESS])->count();
        $qarsToBeDone = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_TOBE_DONE])->count();
        $qarsCompleted = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_COMPLETED])->count();
        $qarsCanceled = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_CANCELED])->count();

        // Sites
        $totalSites = Site::queryByCompany()->count();

        // Users
        $totalUsers = User::queryByCompany()->andWhere(["status" => User::STATUS_ACTIVE])->count();
        $totalFieldTech = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_TECH])->andWhere(["status" => User::STATUS_ACTIVE])->count();
        $totalBuyer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_BUYER])->andWhere(["status" => User::STATUS_ACTIVE])->count();
        $totalFarmer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_FARMER])->andWhere(["status" => User::STATUS_ACTIVE])->count();

        // chart
        $period = CashewAppHelper::getDatePeriodToFetch($startDate, $endDate);
        if (empty($period))
            return $this->redirect(["/"]);

        $categories = array_map( function ($date){ return $date["generic"];}, $period);
        $qarSeries = SiteHelper::getQarChart($period);
        $qarPieSeries = SiteHelper::getQarPieChart($period);


        if(!$country_code) {
            $country_code = Yii::$app->params['DEFAULT_COUNTRY_CODE'];
        }
        $siteSeries = SiteHelper::getSitesChart($startDate, $endDate, null, $country_code);
        $korLocations = SiteHelper::getSitesKorWithLocationChart($startDate, $endDate, null, $country_code);

        $userSeries = SiteHelper::getUsersChart($period);

        return $this->render('index', [
            'qarsInProgress' => $qarsInProgress,
            'qarsToBeDone' => $qarsToBeDone,
            'qarsCompleted' => $qarsCompleted,
            'qarsCanceled' => $qarsCanceled,
            'totalSites' => $totalSites,
            'totalUsers' => $totalUsers,
            'totalFieldTech' => $totalFieldTech,
            'totalBuyer' => $totalBuyer,
            'totalFarmer' => $totalFarmer,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'predefinedPeriod' => $predefinedPeriod,
            'categories' => $categories,
            'qarSeries' => $qarSeries,
            'qarPieSeries' => $qarPieSeries,
            'siteSeries' => $siteSeries,
            'korLocations' => $korLocations,
            'country_code'=> $country_code,
            'userSeries' => $userSeries
        ]);

    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        // Logout the user if logged in
        Yii::$app->user->logout();

        $this->layout = "login";
        if ( ! Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);

    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset($requestOrigin = "web")
    {
        CashewAppHelper::getRequestOriginInSession($requestOrigin);
        // Logout the user if logged in
        Yii::$app->user->logout();

        $this->layout = "login";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $message = null;
            $messageType = null;

            if ($model->sendEmail()) {
                $message = Yii::t('app','Check your email for further instructions.');
                $messageType = "success";

            } else {
                $message = Yii::t('app', 'Sorry, we are unable to reset password for the provided email address.');
                $messageType = "danger";
            }

            return $this->render("blank", [
                "message" =>$message,
                "type" =>$messageType,
                "loginLink" => false
            ]);
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
    public function actionResetPassword($token, $requestOrigin = "web")
    {
        CashewAppHelper::getRequestOriginInSession($requestOrigin);
        // Logout the user if logged in
        Yii::$app->user->logout();

        $this->layout = "login";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            return $this->render("blank", [
                "message" => Yii::t('app','Invalid password reset link'),
                "type" => "danger",
                "loginLink" => false
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            return $this->render("blank", [
                "message" => Yii::t('app','New password saved successfully. You can use it and login'),
                "type" => "success",
                "loginLink" => CashewAppHelper::getRequestOriginInSession() == CashewAppHelper::REQUEST_ORIGIN_WEB
            ]);
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
        // Logout the user if logged in
        Yii::$app->user->logout();

        $this->layout = "login";

        $model = User::findOne(["verification_token" => $token, "status"=> User::STATUS_WAITING_FOR_ACTIVATION]);

        if(!$model){
            return $this->render("blank", [
                "message" => Yii::t("app", "Invalid verification link"),
                "type" => "danger",
                "loginLink" => false
            ]);
        }

        $model->status = User::STATUS_ACTIVE;
        $model->verification_token = null;

        $message = null;
        $messageType = null;

        if($model->save(false)){
            $message = Yii::t("app", "Account activated successfully, Please consider changing your password!");
            $messageType = "success";
        } else {
            $message = Yii::t("app", "Could not activate account");
            $messageType = "danger";
        }

        return $this->render("blank", [
            "message" =>$message,
            "type" =>$messageType,
            "loginLink" => CashewAppHelper::getRequestOriginInSession() == CashewAppHelper::REQUEST_ORIGIN_WEB
        ]);
    }
}
