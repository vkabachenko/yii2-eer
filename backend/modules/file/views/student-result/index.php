<?php

use common\models\Program;
use common\models\StudentEducation;
use common\models\StudentResult;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $program Program */
/* @var $idParent integer */
/* @var $student StudentEducation */
/* @var $result StudentResult */

$result = StudentResult::findOne($idParent);
$student = StudentEducation::findOne($result->id_student_education);
$program = Program::findOne($student->id_program);


$this->title = 'Файлы';
$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Студенты',
    'url' => ['/student',
        'idParent' => $student->id_program],
];

$this->params['breadcrumbs'][] = [
    'label' => 'Результаты',
    'url' => ['/student/results/index',
        'id' => $student->id],
];

$this->params['breadcrumbs'][] = $this->title;


?>
<h2>Файлы</h2>
<h3>
    Студент: <?= $student->studentName ?>
    Дисциплина: <?= $result->idDisciplineSemester->idDiscipline->fullName ?>
</h3>

<?php require(Yii::$app->basePath.'/views/gridFile/index.php'); ?>

<?php


