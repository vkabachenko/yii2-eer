<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $disciplines array */
/* @var $disciplineName common\models\DisciplineName */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($disciplineName, 'id_discipline')->
    dropDownList($disciplines)->label('Шифр'); ?>
<?= $form->field($disciplineName, 'suffix')->textInput(['maxlength' => true]); ?>
<?= $form->field($disciplineName, 'name')->textInput(['maxlength' => true]); ?>


<div class="form-group submitBlock">
    <?= Html::submitButton('Сохранить', [
        'class' => 'btn btn-success',
        'name' => 'submitButton'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

