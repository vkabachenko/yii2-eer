<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\StudentEducation;
use common\helpers\YearHelper;


/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $idParent integer */

require(Yii::$app->basePath.'/views/grid/index.php');

/* @var $student StudentEducation */
$student = StudentEducation::find()->where([
    'id_student' => $idParent,
    'year' => YearHelper::getYear()
])->one();

$this->title = 'Пользователь';

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

$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Пользователь системы</h2>

<h3>
    Студент: <?= $student->studentName ?>
</h3>


<p>
    <?= Html::a('Новый логин', ['create','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionCreate',
        ]) ?>
    <?php


    ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'username',
        'email',
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
