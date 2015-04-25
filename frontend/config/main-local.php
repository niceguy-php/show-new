<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-lOLWc5MNJdrC1Pzu9yTsryd4Yj1vqYQ',
        ],
        'urlManager' => [
            'class'=> 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'article'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'gallery'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'work'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'exhibition-hall'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'show-room'],
            ],
        ],
    ],

];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
    /*$config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'mongoDbModel' => [
                'class' => 'yii\mongodb\gii\model\Generator'
            ]
        ],
    ];*/
}

return $config;
