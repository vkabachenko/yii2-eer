<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\Discipline;
use common\models\DisciplineName;

/* @var $this yii\web\View */
/* @var $results[] \common\models\StudentResult */
/* @var $model \common\models\StudentResult */
/* @var $discipline \common\models\Discipline */
/* @var $form yii\widgets\ActiveForm */

$model = $results[0];
$discipline = $model->idDisciplineSemester->idDiscipline;
?>

<h4>Дисциплина: <?= $discipline->fullName ?></h4>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<!-- Для первой строки массива моделей вводим
название ДПВ, дату сдачи и экзаменатора -->

<?php if ($discipline->block == Discipline::DISCIPLINE_CHOICE): ?>
    <?php $disciplineList = DisciplineName::getDisciplineList($discipline->id); ?>

    <?= $form->field($model, "[0]id_discipline_name", ['inputOptions'=>[
                             'class' => 'disciplineName']])->
        dropDownList($disciplineList); ?>
<?php else: ?>
    <?= $form->field($model, "[0]id_discipline_name", ['inputOptions'=>[
                             'class' => 'disciplineName']])->
        hiddenInput()->label(false); ?>
<?php endif; ?>


<?= $form->field($model, "[0]passing_date")
         ->widget(DatePicker::classname(), [
                 'language' => 'ru',
                 'dateFormat' => 'dd-MM-yyyy',
                 'options' => ['class' => 'passingDate']
          ]) ?>
<?= $form->field($model, "[0]examiner",
    ['inputOptions'=>[
        'class' => 'examiner',
        'style' => 'width:60%;'
    ]
]); ?>

<!-- Для остальных строк - дата сдачи и экзаменатор - в скрытых полях,
  заполняются из 1-й строки с помощью скрипта js -->

<?php

    for ($i=1; $i < count($results); $i++) {

        $item = $results[$i];
        echo $form->field($item, "[$i]id_discipline_name",
            ['inputOptions'=>[
                'class' => 'disciplineNameHidden',
            ]
            ])->hiddenInput()->label(false);
        echo $form->field($item, "[$i]passing_date",
                         ['inputOptions'=>[
                           'class' => 'passingDateHidden',
                             ]
                         ])->hiddenInput()->label(false);
        echo $form->field($item, "[$i]examiner",
                         ['inputOptions'=>[
                           'class' => 'examinerHidden',
                             ]
                         ])->hiddenInput()->label(false);
    }

?>

<!-- Студенты, оценки и рейтинг - в таблице -->

<table class="table table-condensed">
    <tr>
        <th>Студент</th>
        <th style="width:15%;">Оценка</th>
        <th style="width:15%;">Рейтинг</th>
    </tr>

    <?php foreach ($results as $i=>$model): ?>

        <tr>
            <td>
                <?= $model->idStudentEducation->idStudent->name; ?>
            </td>
            <td>
               <?= $form->field($model, "[$i]assesment")->label(false); ?>
            </td>
            <td>
                <?= $form->field($model, "[$i]rating")->label(false); ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$script =
    <<<JS

$('.disciplineName').on('change',function(){

    var value = $(this).val();
    $('.disciplineNameHidden').each(function() {
        $(this).val(value);
    }
    )

});

$('.passingDate').on('change',function(){

    var value = $(this).val();
    $('.passingDateHidden').each(function() {
        $(this).val(value);
    }
    )

});

$('.examiner').on('change',function(){

    var value = $(this).val();
    $('.examinerHidden').each(function() {
        $(this).val(value);
    }
    )

});

$('.disciplineName').trigger('change');
$('.passingDate').trigger('change');
$('.examiner').trigger('change');

JS;
$this->registerJs($script);

?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>
