<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $student \common\models\Student */
/* @var $studentEducation \common\models\StudentEducation */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($student, 'name')->textInput(['maxlength' => true]); ?>
<?= $form->field($student, 'email')->textInput(['maxlength' => true]); ?>
<?= $form->field($studentEducation, 'course')->textInput(); ?>
<?= $form->field($studentEducation, 'group')->textInput(['maxlength' => true]); ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

