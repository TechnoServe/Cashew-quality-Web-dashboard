<?php


namespace backend\models;


use Yii;

class Qar extends \common\models\Qar
{

    const INITIATED_BY_FIELD_TECH = 1;

    const INITIATED_BY_BUYER = 2;

    const INITIATED_BY_FARMER = 3;

    const STATUS_TOBE_DONE = 1;

    const STATUS_IN_PROGRESS = 2;

    const STATUS_COMPLETED = 3;

    const STATUS_CANCELED = 4;

    /**
     *
     */
    const FIELD_NUMBER_OF_BAGS_SAMPLED = 'number_bag_sampled';
    const FIELD_TOTAL_NUMBER_OF_BAGS = 'number_total_bags';
    const FIELD_VOLUME_TOTAL_STOCK = 'volume_total_stock';
    const FIELD_NUT_WEIGHT = 'nut_weight';
    const FIELD_NUT_COUNT = 'nut_count';
    const FIELD_MOISTURE_CONTENT = 'moisture_content';
    const FIELD_FOREIGN_MATERIAL = 'foreign_materials';
    const FIELD_GOOD_KERNEL = 'good_kernel';
    const FIELD_SPOTTED_KERNEL = 'spotted_kernel';
    const FIELD_IMMATURE_KERNEL = 'immature_kernel';
    const FIELD_OILY_KERNEL = 'oily_kernel';
    const FIELD_BAD_KERNEL = 'bad_kernel';
    const FIELD_VOID_KERNEL = 'void_kernel';
    const FIELD_LOT_INFO='lot_info';
    const FIELD_REQUEST_ID= 'request_id';
    const FIELD_CREATED_AT= 'created_at';
    /**
     *
     */

    /**
     *
     */
    const RESULT_KOR = 'kor';
    const RESULT_DEFECTIVE_RATE = 'defective_rate';
    const RESULT_FOREIGN_MATERIAL_RATE = 'foreign_material_rate';
    const RESULT_MOISTURE_CONTENT = 'moisture_content';
    const RESULT_NUT_COUNT = 'nut_count';
    const RESULT_USEFUL_KERNEL = 'useful_kernel';

    /**
     * Labels for qar measurements
     * @return array
     */
    public static function qarMeasurementFieldLabels(){
        return [
            self::FIELD_NUMBER_OF_BAGS_SAMPLED => Yii::t("app", "Number of bags sampled"),
            self::FIELD_TOTAL_NUMBER_OF_BAGS => Yii::t("app", "Total number of bags"),
            self::FIELD_VOLUME_TOTAL_STOCK => Yii::t("app", "Total volume of stock"),
            self::FIELD_NUT_WEIGHT => Yii::t("app", "Nut weight"),
            self::FIELD_NUT_COUNT => Yii::t("app", "Nut count"),
            self::FIELD_MOISTURE_CONTENT => Yii::t("app", "Moistrue content"),
            self::FIELD_FOREIGN_MATERIAL => Yii::t("app", "Foreign material"),
            self::FIELD_GOOD_KERNEL => Yii::t("app", "Good kernel"),
            self::FIELD_SPOTTED_KERNEL => Yii::t("app", "Spotted kernel"),
            self::FIELD_IMMATURE_KERNEL => Yii::t("app", "Immature kernel"),
            self::FIELD_OILY_KERNEL => Yii::t("app", "Oily kernel"),
            self::FIELD_BAD_KERNEL => Yii::t("app", "Bad kernel"),
            self::FIELD_VOID_KERNEL => Yii::t("app", "Void kernel"),
        ];
    }

    /**
     * Labels for qar results
     * @return array
     */
    public static function qarResultLabels(){
        return [
            self::RESULT_KOR => Yii::t("app", "KOR"),
            self::RESULT_DEFECTIVE_RATE => Yii::t("app", "Defective rate"),
            self::RESULT_FOREIGN_MATERIAL_RATE => Yii::t("app", "Foreign material rate"),
            self::RESULT_MOISTURE_CONTENT => Yii::t("app", "Moisture content rate"),
            self::RESULT_NUT_COUNT => Yii::t("app", "Nut count"),
            self::RESULT_USEFUL_KERNEL => Yii::t("app", "Useful kernel"),
        ];
    }

    /**
     * Query users by company
     * @return \yii\db\ActiveQuery
     */
    public static function queryByCompany(){
        $loggedInUser = Yii::$app->user->identity;

        if($loggedInUser->role != User::ROLE_ADMIN && $loggedInUser->role != User::ROLE_ADMIN_VIEW) {

            if($loggedInUser->role == User::ROLE_INSTITUTION_ADMIN || $loggedInUser->role == User::ROLE_INSTITUTION_ADMIN_VIEW)
                return self::find()->where(["company_id" => $loggedInUser->company_id]);

            if($loggedInUser->role == User::ROLE_FIELD_TECH)
                return self::find()->where(["company_id" => $loggedInUser->company_id])->andWhere(["field_tech"=>$loggedInUser->id]);


            if($loggedInUser->role == User::ROLE_FIELD_BUYER)
                return self::find()->where(["company_id" => $loggedInUser->company_id])->andWhere(["buyer"=>$loggedInUser->id]);


            if($loggedInUser->role == User::ROLE_FIELD_FARMER)
                return self::find()->where(["company_id" => $loggedInUser->company_id])->andWhere(["farmer"=>$loggedInUser->id]);

        }

        return self::find();
    }


    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                'farmer',
                'required',
                'when' => function ($model) {
                    return $model->initiator == self::INITIATED_BY_FARMER;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#qar-initiator').val() == 3;
                }",
                'skipOnEmpty' => true,
                'skipOnError' => true
            ],
        ]);
    }

    /**
     * get qar initiator dropdown values
     *
     * @return array
     */
    public static function getInitiatorDropDownValues()
    {
        return [
            self::INITIATED_BY_FIELD_TECH => Yii::t("app",
                "Initiated by Field Tech"),
            self::INITIATED_BY_BUYER => Yii::t("app", "Initiated by Buyer"),
            self::INITIATED_BY_FARMER => Yii::t("app", "Initiated by Farmer"),
        ];
    }




    public static function getStatusDropDownValues()
    {
        return [
            self::STATUS_TOBE_DONE => Yii::t("app", "To be done"),
            self::STATUS_IN_PROGRESS => Yii::t("app", "In Progress"),
            self::STATUS_COMPLETED => Yii::t("app", "Completed"),
            self::STATUS_CANCELED => Yii::t("app", "Canceled"),
        ];
    }

    /**
     * Get qar status by index/value
     *
     * @param $index
     *
     * @return mixed|null
     */
    public static function getQarStatusByIndex($index)
    {
        $statusValues = self::getStatusDropDownValues();

        return isset($statusValues[$index]) ? $statusValues[$index] : null;
    }


    /**
     * Get initiator name by index/value
     *
     * @param $index
     *
     * @return mixed|null
     */
    public static function getInitiatorByIndex($index)
    {
        $initiatorValues = self::getInitiatorDropDownValues();

        return isset($initiatorValues [$index]) ? $initiatorValues [$index] : null;
    }



    /**
     * Clean input data to ensure data validation
     */
    public function purifyInput(){

        $currentUser = Yii::$app->user->identity;

        //validate buyer
        if(!User::queryByCompany()->andWhere(["id"=>$this->buyer, "role"=>User::ROLE_FIELD_BUYER])->exists())
            $this->buyer = null;


        //validate fieldtech
        if(!User::queryByCompany()->andWhere(["id"=>$this->field_tech, "role"=>User::ROLE_FIELD_TECH])->exists())
            $this->field_tech = null;


        //validate farmer
        if(!User::queryByCompany()->andWhere(["id"=>$this->farmer, "role"=>User::ROLE_FIELD_FARMER])->exists())
            $this->farmer = null;


        //validate site
        if(!Site::queryByCompany()->andWhere(["id"=>$this->site])->exists())
            $this->site = null;

        // If user is not an institution admin
        if ($currentUser->role != User::ROLE_ADMIN && $currentUser->role != User::ROLE_ADMIN_VIEW) {

            if ($currentUser->role == User::ROLE_FIELD_TECH) {
                $this->field_tech = $currentUser->id;
            }

            if ($currentUser->role == User::ROLE_FIELD_BUYER) {
                $this->buyer = $currentUser->id;
            }

            if ($currentUser->role == User::ROLE_FIELD_FARMER) {
                $this->farmer = $currentUser->id;
            }
        }

        $this->company_id = $currentUser->company_id;
    }

    public static function getQarCountsByStatusAndTimePeriod($dates, $status)
    {
        $data = [];
        foreach ($dates as $date) {
            array_push($data, (int) self::find()
                ->where([">=", "DATE(created_at)", date('Y-m-d', strtotime($date["startDate"]))])
                ->andWhere(["<=", "DATE(created_at)", date('Y-m-d', strtotime($date["endDate"]))])
                ->andWhere(["status" => $status])
                ->count()
            );
        }
        return $data;
    }

    public static function getAverageQarByTimePeriod($dates)
    {
        $data = [];
        foreach ($dates as $date) {
            array_push($data, (float) self::find()
                ->innerJoin(QarDetail::tableName(), "qar.id = qar_detail.id_qar")
                ->where([">=", "DATE(qar.created_at)", date('Y-m-d', strtotime($date["startDate"]))])
                ->andWhere(["<=", "DATE(qar.created_at)", date('Y-m-d', strtotime($date["endDate"]))])
                ->andWhere(["qar.status" => Qar::STATUS_COMPLETED])
                ->andWhere(["qar_detail.key" => Qar::RESULT_KOR])
                ->andWhere(["qar_detail.result" => 1])
                ->average("qar_detail.value")
            );    
        }
        return $data;
    }
}