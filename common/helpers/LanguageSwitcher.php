<?php

namespace common\helpers;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\Cookie;

class LanguageSwitcher implements BootstrapInterface
{

    public $languages = [
        'en' => 'English',
        'fr' => 'French',
        'pt' => 'Portuguese',
    ];

    public function bootstrap($app)
    {
        if( php_sapi_name() === 'cli' ) {
            return TRUE;
        }

        $chosenLanguage = Yii::$app->request->get( 'language' );
        if( $chosenLanguage ) {
            if( isset( $this->languages[ $chosenLanguage ] ) ) {

                Yii::$app->language = $chosenLanguage;

                $cookie = new Cookie( [
                    'name' => 'language',
                    'value' => $chosenLanguage,
                    'httpOnly' => true,
                ]);
                \Yii::$app->getResponse()->getCookies()->add($cookie);
            }
        }
        elseif( \Yii::$app->getRequest()->getCookies()->has( 'language' ) ) {
            Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue( 'language' );
        }
        return;
    }
}