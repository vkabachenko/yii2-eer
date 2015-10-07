<?php
/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $student \common\models\StudentEducation */

use common\models\Program;
use yii\grid\GridView;
use common\models\Discipline;
use yii\helpers\Html;

/* @var $program Program */
$program = Program::findOne($student->id_program);

$this->title = 'Результаты';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program/main/index',
        'id_faculty' => $program->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Студенты',
    'url' => ['main/index',
        'id_program' => $student->id_program],
];

$this->params['breadcrumbs'][] = $this->title;

?>

    <h2>Результаты</h2>
    <h3>
        Студент: <?= $student->studentName ?> Курс: <?= $student->course ?>
    </h3>


<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'attribute' => 'code',
            'format' => 'raw',
            'header' => 'Дисциплина',
            'value' => function($model, $key, $index, $column) {
                           $disciplineName = Discipline::findOne($model['id_discipline'])->fullName;
                           if ($model['id_result']) {
                               return Html::a($disciplineName,['result/view-student','id' => $model['id_result']]);
                           }
                           else {
                               return $disciplineName;
                           }
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
    ]
]);

?>

