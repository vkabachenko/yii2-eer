<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $idParent integer */
/* @var $fileControllerName string */

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
            'class' => 'btn btn-success actionCreate',
        ]) ?>
</p>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [ // column for code attribute as a link
            'attribute' => 'code',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->code),
                        ['/student','idParent' => $model->id, ],
                        ['data-pjax' => '0','data-toggle' => 'tooltip',
                            'title' => 'Перейти к студентам',]);                }
        ],
        [ // column for name attribute as a link
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                return Html::a(Html::encode($model->name),
                    ['/discipline','idParent' => $model->id, ],
                    ['data-pjax' => '0','data-toggle' => 'tooltip',
                        'title' => 'Перейти к дисциплинам',]);                }
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
            'template' => '{update}{delete}{file}{name}',
            'buttons' => [
                'update' => 'actionUpdate',
                'delete' => 'actionDelete',
                'file' => 'actionFile',
                'name' => 'actionName',
            ]
        ],
    ],
]); ?>

<?php Pjax::end(); ?>

<?php
// отображение названия программы. Без Ajax
function actionName($url,$model,$key) {
/* @var $model yii\db\ActiveRecord */

$url = Url::to(['name/index','idParent' => $key]);
return Html::a('<span class="glyphicon glyphicon-tags"></span>',
$url,[
'class' => 'actionName',
'data-pjax' => '0',
'data-toggle' => 'tooltip',
'title' => 'Состав названия программы',
]);
}
?>




