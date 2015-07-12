<?php

use common\models\Program;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $program Program */
/* @var $idParent integer */

$program = Program::findOne($idParent);

$this->title = 'Файлы';

$this->params['breadcrumbs'][] = [
    'label' => 'Образовательная программа',
    'url' => ['/program',
        'idParent' => $program->id_faculty],
];
$this->params['breadcrumbs'][] = $this->title;

?>
<h2>Файлы</h2>
<h3>
    Образовательная программа: <?= "$program->code $program->name $program->profile" ?>
</h3>

<?php require(Yii::$app->basePath.'/views/gridFile/index.php'); ?>

<?php


