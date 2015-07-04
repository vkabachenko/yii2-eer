<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/** @var $provider yii\data\ActiveDataProvider */
/* @var $title string */

$this->title = 'Факультеты';

?>

    <h2>Факультеты</h2>
    <?= ListView::widget([
        'dataProvider' => $provider,
        'itemView' => '_faculty',
        'summary' => '',
        'options' => ['id' => 'facultyList',],
        'itemOptions' => ['class' => 'faculty',]
    ]); ?>
