<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model common\models\Faculty */
?>

    <?= Html::a(Html::encode($model->name),
                 Url::to(['/program/main/index','id_faculty' => $model->id, ]));
    ?>
