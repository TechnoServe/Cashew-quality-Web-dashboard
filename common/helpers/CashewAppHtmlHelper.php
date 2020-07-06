<?php


namespace common\helpers;


use Yii;
use yii\helpers\Html;

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
}