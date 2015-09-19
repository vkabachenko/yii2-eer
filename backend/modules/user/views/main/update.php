<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Faculty;
use yii\helpers\ArrayHelper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \common\models\User */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'password')->passwordInput(); ?>
<?= $form->field($model, 'repassword')->passwordInput(); ?>

<?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN): ?>
<?php
    // Список факультетов
    $faculties = ArrayHelper::map(Faculty::find()->orderBy('name')->all(),'id','name');
?>
<?= $form->field($model, 'id_faculty')->dropDownList($faculties); ?>
<?php endif; ?>

<?php
    // массив для списка выбора ролей. Оставляем только роли с ключами 1 и 2
    // (инспектор и локальный администратор)
    $roles =  array_slice(Yii::$app->params['decode']['user.role'],1,2,true);

?>
<?= $form->field($model, 'role')->dropDownList($roles); ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

