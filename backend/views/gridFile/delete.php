<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\File */

?>
<p>
    Удалить файл <?= Html::a($model->document,['/file/main/download','id' => $model->id]); ?>
</p>

<?= Html::a('Удалить',['delete','id' => $model->id],
    ['class' => 'btn btn-primary',
        'id' => 'deleteButton']); ?>

<?php require(Yii::$app->basePath.'/views/grid/delete.php'); ?>
