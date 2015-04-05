<?php
use kartik\datecontrol\Module;
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    // 'sourceLanguage' => 'zh-CN',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'app' => 'app.php',
                        'app-gallery'=>'gallery.php',
                        'app-index'=>'app-index.php',
                        'app/error' => 'error.php',
                    ],
                    //'fileMap' => 'app.php'
                ],
            ],
        ],
    ],
    'modules' => [
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                Module::FORMAT_DATE => 'yyyy-MM-dd',
                Module::FORMAT_TIME => 'HH:mm:ss',
                Module::FORMAT_DATETIME => 'yyyy-MM-dd HH:mm:ss',
            ],

            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            'autoWidget' => true,
        ]
    ],
];
