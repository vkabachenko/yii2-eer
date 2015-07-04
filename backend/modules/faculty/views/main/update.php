<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Faculty */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>


<!-- Additional -->

<!-- Js script for ajax submitting form -->

<?php

$script =
    <<<JS

$('#updateForm').on('beforeSubmit',function(){ // runs after validation

    $.post( // method - post
        $(this).attr('action'), // url in form's action
        $(this).serialize(),    // all form's data - to query string
        function(data) {            // update action returns success
                    var interval = data ? 1000 : 0; //timeout interval for creation - 1 sec
                    $('#modalWindow .modal-body').html(data); // alert message if needed
                    // show alert message and hide
                    setTimeout(function(){
                        $('#modalWindow').modal('hide'); // hide modal window
                        $.pjax.reload({container:"#pjaxWrap"}); // reload grid
                    },interval);
        });

    return false; // stops further submitting actions

});

JS;

$this->registerJs($script);




