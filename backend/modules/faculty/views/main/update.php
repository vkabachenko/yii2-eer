<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Faculty */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
    'id' => 'updateForm',
    'options' => [
        'name' => 'uploadForm',
        'enctype'=>'multipart/form-data'
    ],
]); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?php
if ($model->filename) {
    echo Html::tag('p',Html::a($model->image,[
    'download',
    'id' => $model->id,
    'modelFile' => '\common\models\Faculty',
    'originalName' => 'image'
    ]));
    echo $form->field($model, 'deleteFlag')->checkbox();
}
echo $form->field($model, 'savedFile')->widget(FileInput::classname(),
[
    'pluginOptions' => [
        'showCaption' => false,
    ]
]);
?>
<div class="form-group submitBlock">
    <?= Html::submitButton('Сохранить', [
        'class' => 'btn btn-success',
        'name' => 'submitButton'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$script = file_get_contents(Yii::getAlias('@webroot/js/upload.js'));
$this->registerJs($script);

