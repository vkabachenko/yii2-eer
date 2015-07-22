<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Program;

    /* @var $this yii\web\View */
/* @var $model common\models\ProgramHeader */
/* @var $form yii\widgets\ActiveForm */

$program = new Program();
$attributes = $program->availableAttributes();
$labels = $program->attributeLabels();
$fields = [];
foreach($attributes as $attribute) {
    $fields[$attribute] = $labels[$attribute];
}

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($model, 'field_shown')->dropDownList($fields); ?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

