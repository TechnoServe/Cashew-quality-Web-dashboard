<?php


namespace common\helpers;


use backend\models\Department;
use common\models\FreeQarResult;
use backend\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use function GuzzleHttp\Psr7\str;

class CashewAppHtmlHelper
{

    /**
     * @param $target_url
     * @param $css_class
     *
     * @return string
     */
    public static function showLinkState($target_url, $css_class)
    {
        $parentUrl = explode("/", Yii::$app->request->pathInfo)[0];

        //$target_url = $target_url ."/";
        //$target_url = str_replace('/', '\/', $target_url);
        //return preg_match('#^'.$target_url.'#i', Yii::$app->request->pathInfo)? 'class="' . $css_class . '"' : '';
        return $parentUrl == $target_url ? 'class="' . $css_class . '"' : '';
    }


    /**
     * @param $url
     * @param $icon_class
     * @param $text
     * @param string $css_class
     *
     * @return string
     */
    public static function showMenuContent($url, $icon_class, $text, $css_class = 'active-link')
    {
        $li = "<li " . self::showLinkState($url, $css_class) . ">";
        if ($url == "HOME") {
            $url = "";
            if (!Yii::$app->request->pathInfo) {
                $li = '<li class="' . $css_class . '"">';

            }
        }

        return $li .
            Html::a(Html::tag('i', '', ['class' => $icon_class]) .
                Html::tag('span', '<strong>' . $text . '</strong>', ['class' => 'menu-title'])
                , '/' . $url
            ) . "</li>";

    }


    /**
     * Construct global datepicker widget values
     * @param $name
     * @param $format
     * @param string $placeholder
     * @param null $strtotime
     *
     * @return array
     */
    public static function getDatePickerWidgetValues($name, $format, $placeholder = "", $strtotime = null, $startDate = null, $endDate = null)
    {
        $params = [
            'name' => $name,
            'language' => Yii::$app->language,
            'value' => date('Y/m/d'),
            'options' => ['placeholder' => $placeholder,],
            'pluginOptions' => [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'format' => 'yyyy/m/dd',
                'todayHighlight' => true,

            ]
        ];
        if ($format == "month") {
            $params['pluginOptions'] = array_merge($params['pluginOptions'], ['minViewMode' => 'months']);
            $params['pluginOptions']['format'] = 'yyyy/m';
        }

        if ($format == "year") {
            $params['pluginOptions'] = array_merge($params['pluginOptions'], ['minViewMode' => 'years']);
            $params['pluginOptions']['format'] = 'yyyy';
        }

        if (!$strtotime) {
            $params['value'] = date('Y-m-d', strtotime($strtotime));
        }

        return $params;
    }

    /**
     * Function helps to show/hide forms
     *
     * @param $role
     *
     * @return bool
     */
    public static function showFieldTechSelectorOnForm($role)
    {
        return $role != User::ROLE_FIELD_BUYER;
    }


    /**
     * Function helps to show/hide forms
     *
     * @param $role
     *
     * @return bool
     */
    public static function showBuyerSelectorOnForm($role)
    {
        return $role != User::ROLE_FIELD_BUYER;
    }

    /**
     * Select 2 widget for countries
     * @param $attribute
     * @param $html_id
     * @param $placeholder
     * @return array
     */
    public static function getCountriesSelectWidgetValues($attribute, $html_id, $placeholder, $byProvince = null, $country_code)
    {
        $countries = CashewAppHelper::getListOfCountries();

        $data = [];
        if ($byProvince) {
            $distinctCountryCodesByExistingProvinces = ArrayHelper::getColumn(Department::find()->select(["country_code"])->distinct()->asArray()->all(), "country_code");
            foreach ($countries as $key => $country) {
                in_array($key, $distinctCountryCodesByExistingProvinces) ? $data[$key] = $country . " [" . $key . "]" :null;
            }
        } else{
            foreach ($countries as $key => $country) {
                 $data[$key] = $country . " [" . $key . "]";
            }
        }

        return [
            'data' => $data,
            'value' => $country_code,
            'name' => $attribute,
            'attribute' => $attribute,
            'language' => Yii::$app->language,
            'options' => ['id' => $html_id, 'placeholder' => $placeholder],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ];
    }

    public static function getCountries($attribute, $html_id, $placeholder, $byRegion = null, $country_code)
    {
        $countries = CashewAppHelper::getListOfCountries();

        $data = [];

        if ($byRegion) {
            $distinctCountryCodesByExistingRegions = ArrayHelper::getColumn(FreeQarResult::find()->select(["location_country_code"])->distinct()->asArray()->all(), "location_country_code");
            foreach ($countries as $key => $country) {
                in_array($key, $distinctCountryCodesByExistingRegions) ? $data[$key] = $country . " [" . $key . "]" :null;
            }
        } else {
            foreach ($countries as $key => $country) {
                $data[$key] = $country . " [" . $key . "]";
            }
        }

        return [
            'data' => $data,
            'value' => $country_code,
            'name' => $attribute,
            'attribute' => $attribute,
            'language' => Yii::$app->language,
            'options' => ['id' => $html_id, 'placeholder' => $placeholder],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ];
    }
   
}