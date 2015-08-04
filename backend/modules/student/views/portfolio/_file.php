<?php

use yii\helpers\Html;
use yii\helpers\Url;

if ($node->filename) {
    echo Html::tag('p',Html::a($node->document,[
                       'download',
                       'id' => $node->id,
                       'modelFile' => '\common\models\StudentPortfolio']));
}
echo $form->field($node, 'savedFile')->fileInput();

