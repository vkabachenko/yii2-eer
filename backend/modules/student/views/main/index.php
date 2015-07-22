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

$this->title = 'Студенты';
$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Студенты</h2>
<h3>
    Образовательная программа: <?= "$program->fullName" ?>
</h3>

<p>
    <?= Html::a('Новый студент', ['create','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionCreate',
        ]) ?>
    <?php

    // TBD: Перевести всех на след курс

    ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [ // column for name attribute as a link
            'attribute' => 'studentName',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->studentName),
                        ['/student/history/index','idParent' => $model->id_student, ],
                        ['data-pjax' => '0']);                }
        ],
        'course',
        'group',
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
