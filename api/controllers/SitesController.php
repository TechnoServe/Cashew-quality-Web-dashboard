<?php

namespace api\controllers;

use api\components\ApiResponse;
use api\models\User;
use backend\models\Site;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class SitesController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($password)) {
                    return $user;
                }
                return null;
            }
        ];

        return array_merge(
            $behaviors,
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'index' => ['GET'],
                        'view' => ['GET']
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            // This functionality has been removed, but we don't want throw it out yet
                            'allow' => false,
                            'roles' => [
                                User::ROLE_FIELD_TECH,
                                User::ROLE_FIELD_BUYER
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Sites list api API
     * @return ApiResponse
     */
    public function actionIndex()
    {
        // Get filter parameters from query params
        $filter = Yii::$app->request->getQueryParams();

        $query = Site::queryByCompany(Yii::$app->user->identity);

        if (isset($filter['site_name']) && !empty($filter['site_name'])) {
            $query->andFilterWhere(["like", "site_name", $filter["site_name"]]);
        }

        if (isset($filter['site_location']) && !empty($filter['site_location'])) {
            $query->andFilterWhere(["like", "site_location", $filter["site_location"]]);
        }

        $sites = $query->asArray()->all();

        $rtn = array_map(function ($site) {
            unset($site["company_id"]);
            unset($site["department_id"]);
            return $site;
        }, $sites);

        return new ApiResponse($rtn, null, true);
    }
}