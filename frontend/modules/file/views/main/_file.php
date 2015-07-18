<?php

use common\models\File;
use yii\helpers\Html;

/* @var $model File */

echo Html::a(Html::encode($model->title),
    ['/file/main/download','id' => $model->id, ]);