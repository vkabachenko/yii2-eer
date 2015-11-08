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
    'label' => 'Студенты',
    'url' => ['main/index',
        'id_program' => $model->idStudentEducation->id_program,
        'page' => Yii::$app->session->get('studentPage')
    ],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Результаты',
    'url' => ['result/index',
        'id' => $model->idStudentEducation->id_student,
        'page' => Yii::$app->session->get('studentResultPage')
    ],
];

$this->params['breadcrumbs'][] = $this->title;


require('_grid.php')

?>





