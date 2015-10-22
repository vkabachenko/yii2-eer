<?php
/* @var $this yii\web\View */
/* @var $id integer */
/* @var $beginNodeId integer */

use kartik\tree\TreeView;
use common\models\StudentPortfolio;
use kartik\tree\Module;
use common\models\StudentEducation;
use common\helpers\YearHelper;
use common\models\User;

/* @var $student StudentEducation */
$student = StudentEducation::find()->where([
                   'id_student' => $id,
                   'year' => YearHelper::getYear()
                   ])->one();

$this->title = 'Портфолио';

if (Yii::$app->user->identity->role <> User::ROLE_STUDENT) {
    $this->params['breadcrumbs'][] = [
        'label' => 'Образовательные программы',
        'url' => ['/program',
            'idParent' => $student->idProgram->id_faculty],
    ];

    $this->params['breadcrumbs'][] = [
        'label' => 'Студенты',
        'url' => ['main/index',
            'idParent' => $student->id_program,
            'page' => Yii::$app->session->get('studentPage')
        ],
    ];
}

$this->params['breadcrumbs'][] = $this->title;

?>

<h2>Портфолио</h2>
<h3>
    Студент: <?= $student->studentName ?> Курс: <?= $student->course ?> Программа: <?= $student->idProgram->fullName ?>
</h3>


<?= TreeView::widget([

    'options' => ['id' => 'idPortfolio'],
    'query' => StudentPortfolio::find()->where(['id_student' => $id])->addOrderBy('root, lft'),
    'showIDAttribute' => false,
    'nodeFormOptions' => [
        'name' => 'nodeForm',
        'enctype'=>'multipart/form-data',
    ],
    'displayValue' => $beginNodeId,
    'isAdmin' => true,         // optional (toggle to enable admin mode)
    'softDelete' => false,       // defaults to true
    'multiple' => false,
    'rootOptions' => [
        'label' => '',
    ],
    'mainTemplate' =>
        '<div class="row">
        <div class="col-sm-5">
            {wrapper}
        </div>
           <div class="col-sm-7">
            {detail}
        </div>
        </div>',
    'wrapperTemplate' => '{tree}{footer}',

    'nodeAddlViews' => [
        Module::VIEW_PART_2 => '@backend/modules/student/views/portfolio/_file',
    ],
    'cacheSettings' => [
        'enableCache' => true   // defaults to true
    ],
    'showTooltips' => false,
]);

$script =
    <<<JS

$('#idPortfolio').treeview("collapseAll");

JS;
$this->registerJs($script);



