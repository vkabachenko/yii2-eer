<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\File */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
    'id' => 'updateForm',
    'options' => [
        'name' => 'uploadForm',
        'enctype'=>'multipart/form-data'
    ],
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'free_access')->checkbox(); ?>
<?php if ($model->filename)
    echo Html::tag('p',Html::a($model->document,['/file/main/download','id' => $model->id]));
?>
<?= $form->field($model, 'savedFile')->fileInput(); ?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$script = file_get_contents(Yii::getAlias('@webroot/js/upload.js'));
$this->registerJs($script);

