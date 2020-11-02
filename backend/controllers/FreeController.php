<?php


namespace backend\controllers;

use backend\helpers\FirestoreHelper;
use backend\helpers\FreeVersionDataHelper;
use backend\models\FreeSite;
use backend\models\FreeUser;
use backend\models\User;
use common\helpers\CashewAppHelper;
use backend\models\FreeQar;
use common\models\FreeQarResult;
use common\models\FreeSites;
use common\models\FreeUsers;
use common\models\Settings;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\JsExpression;

class FreeController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN,
                            User::ROLE_ADMIN_VIEW
                        ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'pull-fire-store' => ['POST'],
                ],
            ],
        ];
    }

    public $fireStoreHelper;

    /**
     * Initialize controller with dependencies
     */
    public function init()
    {
        $this->fireStoreHelper = new FirestoreHelper();
        parent::init(); // TODO: Change the autogenerated stub
    }


    /**
     * Default action
     */
    public function actionIndex($startDate = null, $endDate = null, $predefinedPeriod = null){

        list($startDate, $endDate)  = CashewAppHelper::calculateStartDateAndEndDateForAnalytics($startDate, $endDate, $predefinedPeriod);

        $freeUsers = FreeUsers::find()->count();
        $freeQar = FreeQar::find()->count();
        $freeSites = FreeSites::find()->count();


        //Period to fetch
        $datesPeriod = CashewAppHelper::getDatePeriodToFetch($startDate, $endDate);

        //If provided invalid date
        if(empty($datesPeriod))
            return $this->redirect(["free/index"]);

        return $this->render("index", [
            'lastSync' => Settings::findOne(FirestoreHelper::SYNC_TIME_SETTING),
            'freeUsers' => $freeUsers,
            'freeQar' => $freeQar,
            'freeSites' => $freeSites,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'predefinedPeriod' => $predefinedPeriod,
            'categories' => array_map( function ($date){ return $date["generic"];}, $datesPeriod),
            'qarSeries' => FreeVersionDataHelper::getQarChartData($datesPeriod),
            'qarPieSeries' => FreeVersionDataHelper::getQarPieChartData($datesPeriod),
            'userSeries' => FreeVersionDataHelper::getUsersChartData($datesPeriod),
            'topSitesPerKor' => FreeSite::findBestSitesPerAverageQarByTimePeriod($startDate, $endDate),
            'topSitesPerQar' => FreeSite::findBestSitesPerNumberOfQarsByTimePeriod($startDate, $endDate),
            'totalSites' => FreeSite::countByPeriod($endDate),
            'totalUsers' => FreeUser::countByPeriod($endDate),
            'totalQar' => FreeQar::countByPeriod($startDate, $endDate),
            'siteKorMarkers' =>FreeQar::getKorsAndSiteLocations($startDate, $endDate),
        ]);
    }

    /**
     * Export free qar in csv
     */
    public function actionExportQarCsv()
    {
        $data = FreeQar::find()->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=free_qars' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Created At'),
            Yii::t('app', 'Buyer'),
            Yii::t('app', 'Field Tech'),
            Yii::t('app', 'Site'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'KOR'),
            Yii::t('app', 'Deffective rate'),
            Yii::t('app', 'Foreign material rate'),
            Yii::t('app', 'Moisture content'),
            Yii::t('app', 'Nut count'),
            Yii::t('app', 'Useful kernel'),
            Yii::t('app', 'Total volume of stock'),
            Yii::t('app', '[Location] Altitude'),
            Yii::t('app', '[Location] Latitude'),
            Yii::t('app', '[Location] Longitude'),
            Yii::t('app', '[Location] Accuracy'),
            Yii::t('app', '[Location] Country'),
            Yii::t('app', '[Location] City'),
            Yii::t('app', '[Location] Region'),
            Yii::t('app', '[Location] Sub Region'),
            Yii::t('app', '[Location] District'),
            Yii::t('app', '[Location] Street'),
            Yii::t('app', 'Audit completed at')
        ]);

        foreach ($data as $row) {
            $buyer = FreeUsers::findOne($row["buyer"]);
            $fieldTech = FreeUsers::findOne($row["field_tech"]);
            $site = FreeSites::findOne($row["site"]);
            $result = FreeQarResult::find()->where(["qar" => $row["document_id"]])->one();
            if(!$result)
                $result = new FreeQarResult();

            $status = null;
            if($row['status'] == 0)
                $status = Yii::t("app", "To Be Done");

            if($row['status'] == 1)
                $status = Yii::t("app", "In progress");

            if($row['status'] == 2)
                $status = Yii::t("app", "Completed");

            fputcsv($output, [
                $row['created_at'],
                $buyer['names'],
                $fieldTech['names'],
                $site['name'],
                $status,
                $result['kor'],
                $result['defective_rate'],
                $result['foreign_material_rate'],
                $result['moisture_content'],
                $result['nut_count'],
                $result['useful_kernel'],
                $result['total_volume_of_stock'],
                $result['location_altitude'],
                $result['location_lat'],
                $result['location_lon'],
                $result['location_accuracy'],
                $result['location_country'],
                $result['location_city'],
                $result['location_region'],
                $result['location_sub_region'],
                $result['location_district'],
                $result['location_street'],
                $result['created_at'],
            ]);
        }
        fclose($output);
        exit();
    }


    /**
     * Print free sites in csv
     */
    public function actionExportSitesCsv()
    {
        $data = FreeSites::find()->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=free_sites' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Created At'),
            Yii::t('app', 'Site Name'),
            Yii::t('app', 'Site Location'),
            Yii::t('app', 'Owner'),
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['created_at'],
                $row['name'],
                $row['location'],
                $row['owner']
            ]);
        }
        fclose($output);
        exit();
    }


    /**
     * Print free users in csv
     */
    public function actionExportUsersCsv()
    {
        $data = FreeUsers::find()->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=free_users' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Created At'),
            Yii::t('app', 'Type'),
            Yii::t('app', 'Names'),
            Yii::t('app', 'Email'),
            Yii::t('app', 'Telephone'),
            Yii::t('app', 'Number QAR(s)'),
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['created_at'],
                $row['user_type'] == 1 ? Yii::t("app", "Field Tech") : Yii::t("app", "Buyer"),
                $row['names'],
                $row['email'],
                $row['telephone'],
                $row['user_type'] == 1 ? FreeQar::find()->where(["field_tech" => $row["document_id"]])->count() : FreeQar::find()->where(["buyer" => $row["document_id"]])->count(),
            ]);
        }
        fclose($output);
        exit();
    }



    /**
     * handle web request to update free version data
     * @return \yii\web\Response
     */
    public function actionPullFireStore(){
        $dbUpdated = $this->fireStoreHelper->updateFreeVersionDb();
        if($dbUpdated){
            \Yii::$app->session->setFlash("success", Yii::t("app", "Successfully updated free version data"));
        }else{
            \Yii::$app->session->setFlash("danger",  Yii::t("app","Could not update free version data"));
        }
        return $this->redirect(["free/index"]);
    }
}