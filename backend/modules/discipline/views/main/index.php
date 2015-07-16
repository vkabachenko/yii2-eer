<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\Program;
use common\models\Discipline;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $program Program */
/* @var $idParent integer */

require(Yii::$app->basePath.'/views/grid/index.php');

$program = Program::findOne($idParent);

$this->title = 'Дисциплины';
$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Дисциплины</h2>
<h3>
    Образовательная программа: <?= "$program->code $program->name $program->profile" ?>
</h3>

<p>
    <?= Html::a('Новая дисциплина', ['create','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionCreate',
        ]) ?>
    <?php
    if (Discipline::find()->
        where(['block' => Discipline::DISCIPLINE_CHOICE])->exists()) {
        echo Html::a('Дополнительная дисциплина по выбору', ['create-additive','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionCreate',
        ]);
    }
    ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'disciplineCode',
        'name',
        [
            'attribute' => 'disciplineSemesters',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                    return Html::a(
                        $model->disciplineSemesters ? $model->disciplineSemesters : 'Не заполнено',
                        ['semester/index','idParent' => $model->id_discipline],
                        ['data-pjax' => '0']);
                }
            ],
        [ // column for grid action buttons
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}{file}',
            'buttons' => [
                'update' => 'actionUpdate',
                'delete' => 'actionDelete',
                'file' => 'actionFile',
            ]
        ],
    ],
]); ?>

<?php Pjax::end(); ?>
