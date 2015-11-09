<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Student;
use common\models\User;


/* @var $this yii\web\View */
/* @var $model \common\models\User */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    /* @var $student Student */
    $student = Student::findOne($model->id_student);

    $model->role = User::ROLE_STUDENT;
    $model->username = $student->email;
    $model->email = $student->email;
}

?>

<?php $form = ActiveForm::begin(['id' => 'updateForm']); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'password')->passwordInput(); ?>
<?= $form->field($model, 'repassword')->passwordInput(); ?>
<?= $form->field($model, 'role')->hiddenInput()->label(false); ?>
<?= $form->field($model, 'sendMail')->checkbox(); ?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php require(Yii::$app->basePath.'/views/grid/update.php'); ?>

