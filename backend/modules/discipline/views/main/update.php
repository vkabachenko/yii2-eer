<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Discipline;

/* @var $this yii\web\View */
/* @var $discipline common\models\Discipline */
/* @var $disciplineName common\models\DisciplineName */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($discipline, 'code_first')->textInput(['maxlength' => true]); ?>
<?= $form->field($discipline, 'code_last')->textInput(['maxlength' => true]); ?>
<?= $form->field($disciplineName, 'name')->textInput(['maxlength' => true]); ?>
<?= $form->field($discipline, 'kind')->dropDownList(\Yii::$app->params['decode']['discipline.kind']); ?>
<?= $form->field($discipline, 'block')->dropDownList(\Yii::$app->params['decode']['discipline.block']); ?>
<?= $form->field($disciplineName, 'suffix')->textInput(['maxlength' => true]); ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$choice = Discipline::DISCIPLINE_CHOICE;

$script =
<<<JS

$('#discipline-block').on('change',function(){

     if ($(this).val() == $choice) { // дисциплина по выбору
         $('.field-disciplinename-suffix').show();
         $('#disciplinename-suffix').focus();
     }
     else {
         $('.field-disciplinename-suffix').hide();
         $('#disciplinename-suffix').val('');
     }
  });
$('#discipline-block').trigger('change');

JS;

$this->registerJs($script);
?>


<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

