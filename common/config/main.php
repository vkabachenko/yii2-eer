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
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['student','inspector','localAdmin','admin'],
            /*
             * student - просмотр своего портфолио и своих результатов
             * inspector - просмотр всех данных о конкретном факультете
             * localAdmin - полный доступ ко всем данным конкретного факультета
             * admin - администратор всей системы
             */
            'itemFile' => '@common/rbac/items.php',
            'assignmentFile' => '@common/rbac/assignments.php',
            'ruleFile' => '@common/rbac/rules.php'
        ],
    ],
];
