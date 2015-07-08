<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/** @var $provider yii\data\ActiveDataProvider */
/* @var $title string */

$this->title = 'Факультеты';

?>

    <?= Html::tag('h2',$this->title); ?>
    <?= ListView::widget([
        'dataProvider' => $provider,
        'itemView' => '_faculty',
        'summary' => '',
        'options' => ['id' => 'facultyList',],
        'itemOptions' => ['class' => 'faculty',]
    ]); ?>
