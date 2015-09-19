<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Авторизация';
?>
<?php $form = ActiveForm::begin(
    [
        'options' => [
            'class' => 'center'
        ]
    ]
); ?>
    <fieldset class="registration-form">
        <?= $form->field($model, 'username')->textInput(); ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>
        <?= $form->field($model, 'rememberMe')->checkbox(); ?>
        <?= Html::submitButton('Авторизация', ['class' => 'btn btn-primary']); ?>
    </fieldset>
<?php ActiveForm::end(); ?>