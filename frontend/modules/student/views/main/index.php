<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\DisciplineSemester;

/* @var $program common\models\Program */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel frontend\modules\student\models\StudentSearch */

$this->title = 'Студенты';
$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program/main/index',
        'id_faculty' => $program->id_faculty],
];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $program;
?>

<h3>
    Образовательная программа: <?= "$program->fullName" ?>
</h3>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'header' => '№ п/п',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                    return Html::a($index + 1,[
                        '/student/result/index',
                        'id' => $model->id_student]);
                }
        ],
        [
            'attribute' => 'studentName',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                    return Html::a($model->studentName,[
                        '/student/portfolio/index',
                        'id' => $model->id_student]);
                }
        ],
        'course',
        'group',
    ],
    'summary' => ''
]);


?>