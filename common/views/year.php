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
