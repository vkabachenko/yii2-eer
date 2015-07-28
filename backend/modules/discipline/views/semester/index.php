<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\Program;
use common\models\Discipline;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $program Program */
/* @var $discipline Discipline */
/* @var $idParent integer */

require(Yii::$app->basePath.'/views/grid/index.php');

$discipline = Discipline::findOne($idParent);
$program = Program::findOne($discipline->id_program);

$this->title = 'Семестры';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];

$this->params['breadcrumbs'][] =  [
    'label' => 'Дисциплины',
    'url' => ['/discipline',
        'idParent' => $discipline->id_program]
];

$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Семестры</h2>
<h3>
    Дисциплина: <?= $discipline->fullName ?>
</h3>

<p>
    <?= Html::a('Новый семестр', ['create','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionCreate',
        ]) ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'course',
        'semester',
        'max_rating',
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
