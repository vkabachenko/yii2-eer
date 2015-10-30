<?php
/* @var $this yii\web\View */
/* @var $idParent integer */
/* @var $courses[] integer */
/* @var $course integer */
/* @var $students[] string */

use common\models\Program;
use yii\helpers\Html;

/* @var $program Program */
$program = Program::findOne($idParent);

$this->title = 'Группы';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Студенты',
    'url' => ['main/index',
        'idParent' => $idParent,
        'page' => Yii::$app->session->get('studentPage')
    ],
];

$this->params['breadcrumbs'][] = $this->title;

?>

<h2>Группы студентов</h2>
<h3>
    Образовательная программа: <?= $program->fullName ?>
</h3>

<?= Html::beginForm(); ?>

<?= Html::label('Выберите курс','course'); ?>
<?= Html::dropDownList('course',$course,$courses,
    [
        'id' => 'course',
        'onchange' => 'this.form.submit()'
    ]); ?>

<?= Html::endForm(); ?>

<?= Html::beginForm(['group-set','idParent' => $idParent],'post',['id' => 'groupForm']); ?>

<p>
<?= Html::label('Задайте группу','group'); ?>
<?= Html::textInput('group'); ?>
</p>


<div class="row">

    <div class="col-md-5" id="divStudents">
        <p>
            <?= Html::label('Список студентов для выбора','listStudents'); ?>
        </p>
        <p>
            <?= Html::listBox('listStudents',null,$students,
                [
                    'id' => 'listStudents',
                    'size' => 10,
                    'multiple' => true,
                    'style' => 'width:100%'
                ]); ?>
        </p>
    </div>

    <div class="col-md-2"  id="rightLeft">
        <p style="text-align: center">
            <?= Html::a('<span class="glyphicon glyphicon-chevron-right"></span>','#',
                   [
                       'id' => 'rightButton'
                   ]); ?>
        </p>
        <p style="text-align: center">
            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>','#',
                  [
                      'id' => 'leftButton'
                  ]); ?>
        </p>
    </div>

    <div class="col-md-5"  id="divChosen">
        <p>
            <?= Html::label('Список выбранных студентов','listChosen'); ?>
        </p>
        <p>
            <?= Html::listBox('listChosen',null,[],
                [
                    'id' => 'listChosen',
                    'size' => 10,
                    'multiple' => true,
                    'style' => 'width:100%'
                ]); ?>
        </p>
    </div>
</div>
<p>
<?= Html::submitButton('Задать группу',['class' => 'btn btn-primary']);  ?>
</p>

<?= Html::endForm(); ?>

<?php
$script =
    <<<JS

    $('#rightButton').click(function() {

        transfer('#listStudents', '#listChosen');

    });

    $('#leftButton').click(function() {

        transfer('#listChosen', '#listStudents');

    });

    $('#groupForm').submit(function() {

        $('#listChosen option').prop('selected',true);

    });

    // center arrows vertically at the beginning
    var heightList = $('#divStudents').outerHeight();
    var heightArrows = $('#rightLeft').outerHeight();
    $('#rightLeft').css('marginTop',(heightList - heightArrows)/2);

    // additional function
    function transfer(from, to) {

        $(from).children(':selected').appendTo(to).prop('selected',false);

        // sort
        var options = $(to +' option');               // Collect options
        options.detach().sort(function(a,b) {               // Detach from select, then Sort
            var at = $(a).text();
            var bt = $(b).text();
            return (at > bt) ? 1 : ((at < bt) ? -1 : 0);  // Tell the sort function how to order
        });
        options.appendTo(to);                          // Re-attach to select
    }
JS;

$this->registerJs($script);





