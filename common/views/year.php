<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['id' => 'updateYearForm']); ?>
<?= $form->field($model, 'year') ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$script =
    <<<JS

$('#updateYearForm').on('beforeSubmit',function(){ // runs after validation

$.post( // method - post
        $(this).attr('action'), // url in form's action
        $(this).serialize()  // all form's data - to query string
      );
    return false; // stops further submitting actions
});
JS;
$this->registerJs($script);



