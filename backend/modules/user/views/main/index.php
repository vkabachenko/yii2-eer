<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\Faculty;


/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $idParent integer */

require(Yii::$app->basePath.'/views/grid/index.php');

/* @var $faculty Faculty */
$faculty = Faculty::findOne($idParent);

$this->title = 'Управление пользователями';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Управление пользователями</h2>
<?php if ($faculty): ?>
<h3>
    Факультет: <?= $faculty->name ?>
</h3>
<?php endif; ?>

<p>
    <?= Html::a('Новый пользователь', ['create','idParent' =>$idParent ],
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
        [   'attribute' => 'facultyName',
            'format' => 'text',
            'value' => function($model, $key, $index, $column) {

                    return $model->id_faculty ? $model->facultyName : '';
                }
        ],
        [   'attribute' => 'role',
            'format' => 'text',
            'value' => function($model, $key, $index, $column) {
                    return Yii::$app->params['decode']['user.role'][$model->role];
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
