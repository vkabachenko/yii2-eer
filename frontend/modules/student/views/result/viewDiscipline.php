<?php

use common\models\StudentResult;

/* @var $this yii\web\View */
/* @var $model StudentResult */

$this->title = 'Просмотр';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program/main/index',
        'id_faculty' => $model->idStudentEducation->idProgram->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Дисциплины',
    'url' => ['/discipline/main/index',
        'id_program' => $model->idDisciplineSemester->idDiscipline->id_program],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Результаты',
    'url' => ['result/discipline',
        'id' => $model->id_discipline_semester],
];

$this->params['breadcrumbs'][] = $this->title;


require('_grid.php')
?>



