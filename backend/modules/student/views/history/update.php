<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Faculty;
use common\models\Program;

$facultyList = Faculty::getFacultyList();

if ($model->isNewRecord) {
    $program = Program::find()->joinWith('idFaculty')->orderBy('faculty.name')->one();
    $model->id_program = $program->id;
}

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


<div class="form-group submitBlock">
    <?= Html::submitButton('Сохранить', [
        'class' => 'btn btn-success',
        'name' => 'submitButton'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$script =
"

$('#faculties').change(function(){

    var self = $(this);

    var program = $('#program');

    // clear previous data
    program.children().each(function(index) {
            $(this).remove();
    });
    var id_faculty = self.val();
            $.ajax({
            'url' : self.data('url'),
            'data' : { 'id' : id_faculty }, // request (GET by default)
            'dataType' : 'json',
            'success' : fillProgram,
            'error' : function() {
                console.log('Error occured while processing ajax request')
            }
        });
});

$('#faculties').change();

// fill program select tag
function fillProgram(dataArr) {

    $.each(dataArr,function(index,data) {
        $('<option></option>').
            appendTo(program).
            val(data.id).
            text(data.fullName);
    })

}

";

$this->registerJs($script);


?>


<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

