<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'YDune3DgXqPwNY02H37qj02RaFSjD61x',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
   $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
   // $config['modules']['gii'] = 'yii\gii\Module';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['generators'] = [
        'kartikgii-crud' => ['class' => 'warrence\kartikgii\crud\Generator'],
    ];
//   $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//        'generators' => [
//            'kartikgii-crud' => [
//                'class' => 'warrence\kartikgii\crud\Generator'
//            ]
//        ],
//    ];
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
