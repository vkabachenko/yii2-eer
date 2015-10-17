<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\Program;
use common\models\StudentEducation;
use common\helpers\YearHelper;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $program Program */
/* @var $idParent integer */
/* @var $student StudentEducation */

require(Yii::$app->basePath.'/views/grid/index.php');

$student = StudentEducation::findOne([
    'id_student' => $idParent,
    'year' => YearHelper::getYear()]);
$program = Program::findOne($student->id_program);

$this->title = 'История';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Студенты',
    'url' => ['/student',
        'idParent' => $student->id_program,
        'page' => Yii::$app->session->get('studentPage')
    ],
];

$this->params['breadcrumbs'][] = $this->title;

?>
<h2>История</h2>
<h3>
    Студент: <?= "$student->studentName" ?>
</h3>

<p>
    <?= Html::a('Новый учебный год', ['create','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionCreate',
        ]) ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'year',
        'programName',
        'course',
        [ // column for grid action buttons
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => 'actionUpdate',
                'delete' => 'actionDelete',
            ]
        ],
    ],
]); ?>

<?php Pjax::end(); ?>
