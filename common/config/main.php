<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)).'/vendor',

    'timeZone' => 'Africa/Kigali',

    // Default language
    'language' => 'en',

    // source language to be English
    'sourceLanguage' => 'en',

    'bootstrap' =>
        [
            ['class' => 'common\helpers\LanguageSwitcher'],
            'queue'
        ],

    'components' => [

        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            // Other driver options
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'cashewnuts.wiredin.test@gmail.com',
                'password' => 'CashewNutsWiredin',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
];
