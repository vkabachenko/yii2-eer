<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $idParent integer */

require(Yii::$app->basePath.'/views/grid/index.php'); ?>

<p>
    <?= Html::a('Новый файл', ['create','idParent' => $idParent],
        [
            'class' => 'btn btn-success',
            'id' => 'actionCreate',
        ]) ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [ // column for name attribute as a link
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                return Html::a(Html::encode($model->title),
                    Url::to(['/file/main/download','id' => $model->id, ]),
                    ['data-pjax' => '0']);                }
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




