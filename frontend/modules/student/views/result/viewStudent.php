<?php

use common\models\StudentResult;

/* @var $this yii\web\View */
/* @var $model StudentResult */

$this->title = 'Просмотр';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'id_faculty' => $model->idStudentEducation->idProgram->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Студенты',
    'url' => ['main/index',
        'id_program' => $model->idStudentEducation->id_program],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Результаты',
    'url' => ['result/index',
        'id' => $model->id_student_education],
];

$this->params['breadcrumbs'][] = $this->title;


require('_grid.php')

?>





