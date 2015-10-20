<?php
/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $student \common\models\StudentEducation */

use common\models\Program;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Discipline;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\GridAsset;

GridAsset::register($this);


/* @var $program Program */
$program = Program::findOne($student->id_program);

$this->title = 'Результаты';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
    ];

$this->params['breadcrumbs'][] = [
    'label' => 'Студенты',
    'url' => ['main/index',
        'idParent' => $student->id_program,
        'page' => Yii::$app->session->get('studentPage')
    ],
];

$this->params['breadcrumbs'][] = $this->title;

?>

<h2>Результаты</h2>
<h3>
Студент: <?= $student->studentName ?> Курс: <?= $student->course ?>
</h3>

<?php Pjax::begin(['options' => ['id' =>'pjaxWrap']]); ?>



<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'attribute' => 'code',
            'format' => 'text',
            'header' => 'Дисциплина',
            'value' => function($model, $key, $index, $column) {
                $discipline = Discipline::findOne($model['id_discipline']);
                return $discipline->fullName;
                }
        ],
        [
            'attribute' => 'semester',
            'header' => 'Семестр',
        ],
        [
            'attribute' => 'assesment',
            'header' => 'Оценка',
        ],
        [
            'attribute' => 'rating',
            'header' => 'Рейтинг',
        ],
        [ // column for grid action buttons
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}{file}',
            'buttons' => [
                'update' => 'actionUpdate',
                'delete' => 'actionDelete',
                'file' => 'actionFile',
                ]
        ]
    ]
]);

?>

<?php Pjax::end(); ?>

    <!-- functions for grid buttons actions -->
<?php


function actionUpdate($url,$model,$key) {

    $url = Url::to(['update',
        'id_student' => $model['id_student'],
        'id_semester' => $model['id_semester'],
        'id_result' => $model['id_result']]);
    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
        $url,[
            'class' => 'actionUpdate',
            'data-pjax' => '0',
        ]);
}

function actionDelete($url,$model,$key) {
  if ($model['id_result']) {
    $url = Url::to(['delete','id' => $model['id_result']]);
    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
        $url,[
            'class' => 'actionDelete',
            'data-pjax' => '0',
        ]);
  }
  else {
      return '';
  }
}


// manage files. Not via ajax
function actionFile($url,$model,$key) {
    /* @var $model yii\db\ActiveRecord */
  if ($model['id_result']) {
    $url = Url::to(["/file/student-result",'idParent' => $model['id_result']]);
    return Html::a('<span class="glyphicon glyphicon-file"></span>',
        $url,[
            'class' => 'actionFile',
            'data-pjax' => '0',
        ]);
  } else {
      return '';
  }
}
?>