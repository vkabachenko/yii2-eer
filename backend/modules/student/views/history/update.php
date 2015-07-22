<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Faculty;
use backend\modules\student\assets\ProgramAsset;

ProgramAsset::register($this);
/* @var $this yii\web\View */
/* @var $model \common\models\StudentEducation */
/* @var $form yii\widgets\ActiveForm */

$facultyList = Faculty::getFacultyList();

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($model, 'year')->textInput(); ?>
<?= $form->field($model, 'course')->textInput(); ?>
<?= $form->field($model, 'group')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'idFaculty')->
            dropDownList($facultyList,[
                'id' => 'faculties',
                'data-url' => Url::to(['/student/history/program']),
    ]); ?>
<?= $form->field($model, 'id_program')->dropDownList([],
                                     ['id' => 'program']); ?>

<?php
// Факультет
// Программа
?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

