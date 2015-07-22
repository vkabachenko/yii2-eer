<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\StudentEducation */

?>
<p>
    Удалить запись о студенте <?= $model->studentName ?> в <?= \common\helpers\YearHelper::getEducationYear() ?> учебном году?
</p>

<?= Html::a('Удалить',['delete','id' => $model->id],
            ['class' => 'btn btn-primary',
             'id' => 'deleteButton']); ?>

<?php require(Yii::$app->basePath.'/views/grid/delete.php'); ?>
