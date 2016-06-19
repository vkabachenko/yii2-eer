<?php
use kartik\tree\TreeView;
use common\models\StudentPortfolio;
use common\models\StudentEducation;
use frontend\assets\FontAwesomeAsset;
use common\helpers\YearHelper;
/* @var $this yii\web\View */
/* @var $id integer */
/* @var $student StudentEducation */

$student = StudentEducation::find()->where([
    'id_student' => $id,
    'year' => YearHelper::getYear()
])->one();

$this->title = 'Портфолио';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program/main/index',
        'id_faculty' => $student->idProgram->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Студенты',
    'url' => ['main/index',
        'id_program' => $student->id_program,
        'page' => Yii::$app->session->get('studentPage')
    ],
];

$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $student;
$this->params['header'] = "{$student->idProgram->fullName} <h3>{$student->studentName}, {$student->course} курс</h3>";
?>

<?php

FontAwesomeAsset::register($this);

echo TreeView::widget([

    'options' => ['id' => 'idPortfolio'],
    'query' => StudentPortfolio::find()->where(['id_student' => $id,])->addOrderBy('root, lft'),
    'displayValue' => 0,
    'fontAwesome' => true,
    'nodeView' => '@frontend/modules/student/views/portfolio/_view',
    'mainTemplate' =>
        '<div class="row">
        <div class="col-sm-6">
            {wrapper}
        </div>
           <div class="col-sm-6">
            {detail}
        </div>
        </div>',
    'wrapperTemplate' => '{tree}',
    'rootOptions' => [
        'label' => '',
    ],
    'showFormButtons' => false,
    'multiple' => false,
    'iconEditSettings' => [
        'show' =>'none',
    ],
    'emptyNodeMsg' => ' ',
    'showTooltips' => false,

]);

$script =
    <<<JS

$('#idPortfolio').treeview("collapseAll");

JS;
$this->registerJs($script);


