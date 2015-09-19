<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'faculty' => [
            'class' => 'backend\modules\faculty\Module',
        ],
        'program' => [
            'class' => 'backend\modules\program\Module',
        ],
        'file' => [
            'class' => 'backend\modules\file\Module',
        ],
        'discipline' => [
            'class' => 'backend\modules\discipline\Module',
        ],
        'student' => [
            'class' => 'backend\modules\student\Module',
        ],
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
