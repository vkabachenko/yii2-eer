<?php
/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $disciplineSemester \common\models\DisciplineSemester */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Результаты';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program/main/index',
        'id_faculty' => $disciplineSemester->idDiscipline->idProgram->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Дисциплины',
    'url' => ['/discipline/main/index',
        'id_program' => $disciplineSemester->idDiscipline->id_program,
        'page' => Yii::$app->session->get('disciplinePage')],
];

$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $disciplineSemester;
$this->params['header'] = "{$disciplineSemester->idDiscipline->idProgram->name}, {$disciplineSemester->idDiscipline->fullName}, {$disciplineSemester->semester} семестр";
?>

<?= GridView::widget([
    'dataProvider' => $provider,
	'summary' => '',
    'columns' => [
        [
            'attribute' => 'code',
            'format' => 'raw',
            'header' => 'Студент',
            'value' => function($model, $key, $index, $column) {
                           if ($model['id_result']) {
                               return Html::a($model['name'],['result/view-discipline','id' => $model['id_result']],
							   ['data-toggle' => 'tooltip',
							    'title' => 'Подробнее',
							   ]);
                           }
                           else {
                               return $model['name'];
                           }
                }
        ],
        [
             'attribute' => 'assesment',
            'header' => 'Оценка',
        ],
        [
            'attribute' => 'rating',
            'header' => 'Рейтинг',
            'value' => function($model, $key, $index, $column) {
                          if ($model['id_result']) {
                              $rating = $model['rating'] ?: '';
                              $max_rating = $model['max_rating'] ?: '';
                              if ($rating || $max_rating) {
                                 return "$rating / $max_rating";
                              }
                              else {
                                  return '';
                              }

                         }
                }
        ]
],

]);

?>

