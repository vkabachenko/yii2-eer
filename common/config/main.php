<?php
return [
    'language' => 'ru',
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
        ]
    ],

    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
