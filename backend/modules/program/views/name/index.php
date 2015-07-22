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

$this->registerCss(".programContent {
        font-weight: bold;
        margin-right: 20px;
        }");

$program = Program::findOne($idParent);

$this->title = 'Отображение наименования';
$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Отображение наименования</h2>
<h3>
    Образовательная программа: <?= $program->fullName ?>
</h3>
<p>
    <?= $program->fullContent ?>
</p>

<p>
    <?= Html::a('Новое поле в наименовании', ['create','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionCreate',
        ]) ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'attribute' => 'field_shown',
            'format' => 'text',
            'value' => function($model, $key, $index, $column) {
                        $program = new Program();
                        $labels = $program->attributeLabels();
                    return $labels[$model->field_shown];
                }
            ],
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
