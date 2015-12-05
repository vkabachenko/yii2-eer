<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\File */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
    'id' => 'updateForm',
    'action' => $model->isNewRecord ? '' : ['update','id' => $model->id],
    'options' => [
        'name' => 'uploadForm',
        'enctype'=>'multipart/form-data'
    ],
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'free_access')->checkbox(); ?>
<?php if ($model->filename)
    echo Html::tag('p',Html::a($model->document,['/file/main/download','id' => $model->id]));
?>
<?php echo $form->field($model, 'savedFile')->widget(FileInput::classname(),
    [
    'pluginOptions' => [
        'showCaption' => false,
        ]
    ]);
?>


<div class="form-group submitBlock">
    <?= Html::submitButton('Сохранить', [
        'class' => 'btn btn-success',
        'name' => 'submitButton'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$script = file_get_contents(Yii::getAlias('@webroot/js/upload.js'));
$this->registerJs($script);

