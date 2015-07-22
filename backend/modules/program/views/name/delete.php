<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\ProgramHeader */

?>
<p>
    Удалить запись о поле <?= $model->fieldShownLabel ?> ?
</p>

<?= Html::a('Удалить',['delete','id' => $model->id],
            ['class' => 'btn btn-primary',
             'id' => 'deleteButton']); ?>

<?php require(Yii::$app->basePath.'/views/grid/delete.php'); ?>
