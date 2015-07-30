<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model \common\models\StudentResult */
/* @var $form yii\widgets\ActiveForm */

?>
<p>Студент: <?= $model->idStudentEducation->studentName ?></p>
<p>Дисциплина: <?= $model->idDisciplineSemester->idDiscipline->fullName ?></p>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>
<?= $form->field($model, 'passing_date')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'dd-MM-yyyy',
]) ?>
<?= $form->field($model, 'examiner')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'assesment')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'rating')->textInput(); ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>
