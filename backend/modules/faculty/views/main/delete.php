<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Faculty */

?>
<p>
    Удалить запись о факультете <?= $model->name ?> ?
</p>

<?= Html::a('Удалить',['delete','id' => $model->id],
            ['class' => 'btn btn-primary',
             'id' => 'deleteButton']); ?>

<!-- Additional -->

<!-- Js script for ajax clicking button -->

<?php

$script =
    <<<JS

$('#deleteButton').click(function(){

    $.post(
        $(this).attr('href'),
        {'approve': 'yes'},
        function() {
                    $('#modalWindow').modal('hide');
                    $.pjax.reload({container:"#pjaxWrap"});
        });

    return false;

});

JS;

$this->registerJs($script);
