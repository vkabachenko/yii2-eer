<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\File */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
    'id' => 'updateForm',
    'options' => [
        'name' => 'uploadForm',
        'enctype'=>'multipart/form-data'
    ],
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'free_access')->checkbox(); ?>
<?php if ($model->filename)
    echo Html::tag('p',Html::a($model->document,['/file/main/download','id' => $model->id]));
?>
<?= $form->field($model, 'savedFile')->fileInput(); ?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$script =
<<<JS

$('#updateForm').on('beforeSubmit',function(){ // runs after validation

var form = document.forms.uploadForm;
var formData = new FormData(form);

$.ajax({
    url: $(this).attr('action'), // url in form's action
    type: 'POST',
    data: formData,
    contentType: false, // обязательно
    processData: false, // для FormData
    success: function(data) {            // update action returns success
        var interval = data ? 1000 : 0; //timeout interval for creation - 1 sec
        $('#modalWindow .modal-body').html(data); // alert message if needed
        // show alert message and hide
        setTimeout(function(){
          $('#modalWindow').modal('hide'); // hide modal window
          $.pjax.reload({container:"#pjaxWrap"}); // reload grid
        },interval);
    }
});

return false; // stops further submitting actions

});

JS;

$this->registerJs($script);



