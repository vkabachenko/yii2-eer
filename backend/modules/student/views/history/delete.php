<?php
use yii\helpers\Html;
use common\helpers\YearHelper;
/* @var $this yii\web\View */
/* @var $model common\models\StudentEducation */

if ($model->year == YearHelper::getYear()):
?>

<p>
    Для удаления записи о текущем годе обучения перейдите в список студентов
</p>

<?php
else:
?>

<p>
    Удалить запись о годе обучения <?= $model->year ?> студента <?= $model->studentName ?>?
</p>

<?= Html::a('Удалить',['delete','id' => $model->id],
            ['class' => 'btn btn-primary',
             'id' => 'deleteButton']); ?>

<?php
endif;
?>

<?php require(Yii::$app->basePath.'/views/grid/delete.php'); ?>
