<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'request' => [
            'baseUrl' => ''
        ],
        'urlManager'=>[
            'class' => 'yii\web\UrlManager',
            'scriptUrl'=>'/index.php',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<action:(login|logout)>' => 'site/<action>',
                'program/<id_faculty:\d+>' => 'program/main/index',
                'discipline/<id_program:\d+>' => 'discipline/main/index',
                'student/<id_program:\d+>' => 'student/main/index',
                'student/result/<id:\d+>' => 'student/result/index',
                'discipline/result/<id:\d+>' => 'student/result/discipline',
                'portfolio/<id:\d+>'  => 'student/portfolio/index',
                'student/discipline/<id:\d+>' => 'student/result/view-student',
                'discipline/student/<id:\d+>' => 'student/result/view-discipline',
            ]
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
    'modules' => [
        'program' => [
            'class' => 'frontend\modules\program\Module',
        ],
        'file' => [
            'class' => 'frontend\modules\file\Module',
        ],
        'discipline' => [
            'class' => 'frontend\modules\discipline\Module',
        ],
        'student' => [
            'class' => 'frontend\modules\student\Module',
        ],
    ],
    'params' => $params,
];
