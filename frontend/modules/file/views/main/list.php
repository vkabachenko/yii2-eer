<?php

use yii\data\ArrayDataProvider;
use yii\widgets\ListView;


/* @var $provider ArrayDataProvider */


echo ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_file',
    'summary' => '',
    'options' => ['id' => 'filesList',],
    'itemOptions' => ['class' => 'file',]
]);


