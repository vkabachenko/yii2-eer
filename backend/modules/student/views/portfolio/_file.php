<?php

use yii\helpers\Html;
use kartik\file\FileInput;

if ($node->filename) {
    echo Html::tag('p',Html::a($node->document,[
                       '/student/portfolio/download',
                       'id' => $node->id,
                       'modelFile' => '\common\models\StudentPortfolio']));
    echo $form->field($node, 'deleteFlag')->checkbox();
}
echo $form->field($node, 'savedFile')->widget(FileInput::classname(),
    [
        'pluginOptions' => [
            'showCaption' => false,
        ]
    ]);

