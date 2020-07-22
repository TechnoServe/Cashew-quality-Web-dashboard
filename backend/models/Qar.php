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
}