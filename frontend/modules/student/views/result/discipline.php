<?php
/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $disciplineSemester \common\models\DisciplineSemester */

use common\models\Program;
use yii\grid\GridView;
use common\models\Discipline;
use yii\helpers\Html;


$this->title = 'Результаты';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'id_faculty' => $disciplineSemester->idDiscipline->idProgram->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Дисциплины',
    'url' => ['/discipline',
        'id_program' => $disciplineSemester->idDiscipline->id_program],
];

$this->params['breadcrumbs'][] = $this->title;

?>

    <h2>Результаты</h2>
    <h3>
        Дисциплина: <?=  $disciplineSemester->idDiscipline->fullName ?> Семестр: <?=  $disciplineSemester->semester ?>
    </h3>


<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'attribute' => 'code',
            'format' => 'raw',
            'header' => 'Студент',
            'value' => function($model, $key, $index, $column) {
                           if ($model['id_result']) {
                               return Html::a($model['name'],['result/view-discipline','id' => $model['id_result']]);
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

