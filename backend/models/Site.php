<?php


namespace backend\models;

use common\models\Site as baseSite;
use Yii;


class Site extends baseSite
{
    private $loggedInUser;

    public function init()
    {

        parent::init();
    }

    /**
     * Query users by company
     * @return \yii\db\ActiveQuery
     */
    public static function queryByCompany(){
        $loggedInUser = Yii::$app->user->identity;

        if($loggedInUser->role != User::ROLE_ADMIN && $loggedInUser->role != User::ROLE_ADMIN_VIEW)
            return self::find()->where(["company_id" =>  $loggedInUser->company_id]);
        return self::find();
    }


    /**
     * Site dropdown values for select2
     * @param $attribute
     * @param $html_id
     * @param $placeholder
     *
     * @return array
     */
    public static function getSiteSelectWidgetValues($attribute , $html_id, $placeholder)
    {
       $allSites = self::queryByCompany()->all();

        $data = [];

        foreach ($allSites as $site){
            $data[$site->id] = $site->site_name. " " . $site->site_location;
        }

        return [
            'data' => $data,
            'attribute' => $attribute,
            'language' => Yii::$app->language,
            'options' => ['id' => $html_id, 'placeholder' => $placeholder],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ];
    }

    /**
     * Clean input data to ensure data validation
     */
    public function purifyInput(){
        $loggedInUser = Yii::$app->user->identity;

        //Set company id
        $this->company_id = $loggedInUser->company_id;
    }
}