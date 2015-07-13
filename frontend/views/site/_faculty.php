<?php

use yii\helpers\Html;

/* @var $model common\models\Faculty */
?>

    <?= Html::a(Html::encode($model->name),
                 ['/program/main/index','id_faculty' => $model->id, ]);
    ?>
