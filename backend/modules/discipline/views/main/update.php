<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $discipline common\models\Discipline */
/* @var $disciplineName common\models\DisciplineName */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($discipline, 'code')->textInput(['maxlength' => true]); ?>
<?= $form->field($disciplineName, 'suffix')->textInput(['maxlength' => true]); ?>
<?= $form->field($disciplineName, 'name')->textInput(['maxlength' => true]); ?>
<?= $form->field($discipline, 'kind')->dropDownList(\Yii::$app->params['decode']['discipline.kind']); ?>
<?= $form->field($discipline, 'block')->dropDownList(\Yii::$app->params['decode']['discipline.block']); ?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

