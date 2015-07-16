<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */

require(Yii::$app->basePath.'/views/grid/index.php');

$this->title = 'Факультеты';
?>
<h2>Факультеты</h2>
<p>
    <?= Html::a('Новый факультет', ['create'],
        [
            'class' => 'btn btn-success actionCreate',
        ]) ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [ // column for name attribute as a link
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                return Html::a(Html::encode($model->name),
                    Url::to(['/program','idParent' => $model->id, ]),
                    ['data-pjax' => '0']);
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




