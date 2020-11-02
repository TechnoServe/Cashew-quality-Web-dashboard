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

        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyCLny8ED_h-OHFmwIRKikex9DNm41bEBiI',
                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],

        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,//The default error log is console/runtime/logs/app.log
            'path' => '@common/notifications/queue',
            'ttr' => 5 * 60, // Max time for anything job handling
            'attempts' => 3, // Max number of attempts
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'cashewnuts.wiredin.test@gmail.com',
                'password' => 'CashewNutsWiredin2',
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
