<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\StudentResult */

if ($model == null):
?>

<p>Результата по данной дисциплине еще нет</p>

<?php
else:

?>

<p>
    Удалить запись о результате промежуточной оценки?

<?= Html::a('Удалить',['delete','id' => $model->id],
            ['class' => 'btn btn-primary',
             'id' => 'deleteButton']); ?>

<?php
endif;
?>

<?php require(Yii::$app->basePath.'/views/grid/delete.php'); ?>
