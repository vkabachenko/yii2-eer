<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<p>
    Удалить запись о логине <?= $model->username ?> ?
</p>

<?= Html::a('Удалить',['delete','id' => $model->id],
            ['class' => 'btn btn-primary',
             'id' => 'deleteButton']); ?>

<?php require(Yii::$app->basePath.'/views/grid/delete.php'); ?>
