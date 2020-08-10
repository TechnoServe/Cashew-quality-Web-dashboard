<?php

namespace backend\controllers;

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
use yii\db\Expression;
use yii\web\JsExpression;

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
                            'search'
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
    public function actionIndex($startDate = null, $endDate = null, $predefinedPeriod = null)
    {

        list($startDate, $endDate)  = CashewAppHelper::calculateStartDateAndEndDateForAnalytics($startDate, $endDate, $predefinedPeriod);

        // QARs
        $qarsInProgress = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_IN_PROGRESS])->count();
        $qarsToBeDone = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_TOBE_DONE])->count();
        $qarsCompleted = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_COMPLETED])->count();
        $qarsCanceled = Qar::queryByCompany()->andWhere(["status" => Qar::STATUS_CANCELED])->count();

        // Users
        $totalUsers = User::queryByCompany()->count();
        $totalFieldTech = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_TECH])->count();
        $totalBuyer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_BUYER])->count();
        $totalFarmer = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_FARMER])->count();

        // chart
        $period = CashewAppHelper::getDatePeriodToFetch($startDate, $endDate);
        if (empty($period))
            return $this->redirect(["/"]);

        $categories = array_map( function ($date){ return $date["generic"];}, $period);

        $series = [];

        // QARs To-Be Done
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "To Be Done"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 1),
                'color' => "#ffb300"
            ]
        );

        // QARs In Progress
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "In Progress"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 2),
                'color' => "#03a9f4"
            ]
        );

        // QARs Completed
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "Completed"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 3),
                'color' => "#26a69a"
            ]
        );

        // QARs Average
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Average QAR"),
                'data' => Qar::getAverageQarByTimePeriod($period),
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white'
                ]
            ]
        );

        //Pie chart
        array_push($series,
            [
                'type' => 'pie',
                'name' => 'Total QARs',
                'title' => false,
                'data' => [
                    [
                        'name' => Yii::t("app", "To Be Done") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[0]['data']),
                        'color' => "#ffb300"
                    ],
                    [
                        'name' => Yii::t("app", "In Progress") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[1]['data']),
                        'color' => "#03a9f4"
                    ],
                    [
                        'name' => Yii::t("app", "Completed") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[2]['data']),
                        'color' => "#26a69a"
                    ],
                ],
                'center' => [30, 30],
                'size' => 100,
                'showInLegend' => true,
                'dataLabels' => [
                    'enabled' => false
                ]
            ]
        );

        return $this->render('index', [
            'qarsInProgress' => $qarsInProgress,
            'qarsToBeDone' => $qarsToBeDone,
            'qarsCompleted' => $qarsCompleted,
            'qarsCanceled' => $qarsCanceled,
            'totalUsers' => $totalUsers,
            'totalFieldTech' => $totalFieldTech,
            'totalBuyer' => $totalBuyer,
            'totalFarmer' => $totalFarmer,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'predefinedPeriod' => $predefinedPeriod,
            'categories' => $categories,
            'series' => $series
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


//    public function actionSearch($q){
//        return $this->render("search", [
//            'q'=>$q,
//            'resultCount'=>10
//        ]);
//    }
}
