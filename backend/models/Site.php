<?php


namespace backend\models;

use common\models\Site as baseSite;
use Yii;


class Site extends baseSite
{


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
       $allSites = self::find()->all();

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
}