<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $idParent integer */

require(Yii::$app->basePath.'/views/grid/index.php');

$this->title = 'Образовательные программы';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Образовательные программы</h2>
<h3>
    Факультет: <?= \common\models\Faculty::findOne($idParent)->name; ?>
</h3>

<p>
    <?= Html::a('Новая программа', ['create','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success',
            'id' => 'actionCreate',
        ]) ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'code',
        [ // column for name attribute as a link
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                return Html::a(Html::encode($model->name),
                    Url::to(['/discipline/main/index','idParent' => $model->id, ]),
                    ['data-pjax' => '0']);                }
        ],
        'profile',
        [
            'attribute' => 'level',
            'format' => 'text',
            'value' => function($model, $key, $index, $column) {
                    return \Yii::$app->params['decode']['program.level'][$model->level];
                }
        ],
        [
            'attribute' => 'form',
            'format' => 'text',
            'value' => function($model, $key, $index, $column) {
                    return \Yii::$app->params['decode']['program.form'][$model->form];
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




