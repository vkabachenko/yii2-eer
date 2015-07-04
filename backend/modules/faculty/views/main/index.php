<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\assets\GridAsset;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */

GridAsset::register($this);

$this->title = 'Факультеты';
?>
<h2>Факультеты</h2>
<p>
    <?= Html::a('Новый факультет', ['create'],
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
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                return Html::a(Html::encode($model->name),
                    Url::to(['/program/main/index','id_faculty' => $model->id, ]));
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



<!-- Additional  -->

<!-- Modal window declaration -->
<?php Modal::begin([
    'id' => 'modalWindow',
    'header' => '<h2>Header</h2>',
]); ?>

<?php Modal::end(); ?>
<!-- End of modal window declaration -->

<!-- functions for grid buttons actions -->
<?php


function actionUpdate($url,$model,$key) {
    $url = Url::to(['update','id' => $key]);
    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
        $url,[
            'class' => 'actionUpdate',
            'data-pjax' => '0',
        ]);
}

function actionDelete($url,$model,$key) {
    $url = Url::to(['delete','id' => $key]);
    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
        $url,[
            'class' => 'actionDelete',
            'data-pjax' => '0',
        ]);
}



?>
<!-- End of functions for grid buttons actions -->
