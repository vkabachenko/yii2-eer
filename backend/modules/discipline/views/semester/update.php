<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DisciplineSemester */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($model, 'course')->textInput(); ?>
<?= $form->field($model, 'semester')->textInput(); ?>
<?= $form->field($model, 'max_rating')->textInput(['maxlength' => true]); ?>


<div class="form-group submitBlock">
    <?= Html::submitButton('Сохранить', [
        'class' => 'btn btn-success',
        'name' => 'submitButton'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

