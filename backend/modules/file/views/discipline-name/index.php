<?php

use common\models\Program;
use common\models\DisciplineName;
use common\models\Discipline;


/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $program Program */
/* @var $disciplineName DisciplineName */
/* @var $discipline Discipline */
/* @var $idParent integer */

$disciplineName = DisciplineName::findOne($idParent);
$discipline = $disciplineName->idDiscipline;
$program = Program::findOne($discipline->id_program);
$code = $disciplineName->disciplineCode;

$this->title = 'Файлы';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательные программы',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];

$this->params['breadcrumbs'][] =  [
    'label' => 'Дисциплины',
    'url' => ['/discipline',
        'idParent' => $disciplineName->id_program_main]
];

$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Файлы</h2>
<h3>
    Дисциплина: <?= "$code $disciplineName->name" ?>
</h3>

<?php require(Yii::$app->basePath.'/views/gridFile/index.php'); ?>

<?php


