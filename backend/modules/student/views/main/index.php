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

    <?= Html::a('Перевести всех на следующий курс', ['transfer','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success actionTransfer',
        ]) ?>

    <?= Html::a('Задать номер группы', ['group','idParent' =>$idParent ],
        [
            'class' => 'btn btn-success',
        ]) ?>

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
                        ['data-pjax' => '0','data-toggle' => 'tooltip',
                            'title' => 'Периоды обучения студента',]);                }
        ],
        'course',
        'group',
        [ // column for grid action buttons
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}{results}{portfolio}{user}',
            'buttons' => [
                'update' => 'actionUpdate',
                'delete' => 'actionDelete',
                'results' => 'actionResults',
                'portfolio' => 'actionPortfolio',
                'user' => 'actionUser',
            ]
        ],
    ],
]); ?>

<?php Pjax::end(); ?>

<?php

// manage results. Not via ajax
function actionResults($url,$model,$key) {
    /* @var $model yii\db\ActiveRecord */
    $url = ["result/index",'id' => $key];
    return Html::a('<span class="glyphicon glyphicon-star"></span>',
        $url,[
            'class' => 'actionResult',
            'data-pjax' => '0',
            'data-toggle' => 'tooltip',
            'title' => 'Результаты',
        ]);
}

// manage portfolio. Not via ajax
function actionPortfolio($url,$model,$key) {
    /* @var $model yii\db\ActiveRecord */
    $url = ["portfolio/index",'id' => $model->id_student];
    return Html::a('<span class="glyphicon glyphicon-info-sign"></span>',
        $url,[
            'class' => 'actionPortfolio',
            'data-pjax' => '0',
            'data-toggle' => 'tooltip',
            'title' => 'Портфолио',
        ]);
}

// manage user. Not via ajax
function actionUser($url,$model,$key) {
    /* @var $model yii\db\ActiveRecord */
    $url = ["user/index",'idParent' => $model->id_student];
    return Html::a('<span class="glyphicon glyphicon-user"></span>',
        $url,[
            'class' => 'actionUser',
            'data-pjax' => '0',
            'data-toggle' => 'tooltip',
            'title' => 'Авторизация в системе',
        ]);
}


?>

<?php

$script =
    <<<JS
       $('.actionTransfer').click(function(){

           $.get($(this).attr('href'),function(data) {

              $('#modalWindow .modal-header h2').text('Перевод');
              $('#modalWindow .modal-body').html(data);
              $('#modalWindow').modal('show');
           });
       return false;
       });
JS;

$this->registerJs($script);
