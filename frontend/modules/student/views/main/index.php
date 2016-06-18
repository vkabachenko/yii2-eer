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
$this->params['header'] = $program->fullName;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'header' => '№/Результ.',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                    return Html::a($index + 1,[
                        '/student/result/index',
                        'id' => $model->id_student],
						['data-toggle' => 'tooltip',
						 'title' => 'Результаты',
						]);
                }
        ],
        [
            'attribute' => 'studentName',
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) {
                    return Html::a($model->studentName,[
                        '/student/portfolio/index',
                        'id' => $model->id_student],
						['data-toggle' => 'tooltip',
						 'title' => 'Портфолио',
						]);
                }
        ],
		'course',
		 
		
		'group',
		 
		
    ],
    'summary' => ''
]);


?>