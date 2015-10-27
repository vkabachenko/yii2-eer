<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $idParent integer */



?>
<p>
    Перевести всех студентов на следующий курс?
</p>

<?= Html::a('Перевести',['transfer','idParent' => $idParent],
            ['class' => 'btn btn-primary',
             'id' => 'transferButton']); ?>

<?php
$script =
    <<<JS

$('#transferButton').click(function(){

    $.post(
        $(this).attr('href'),
        {'approve': 'yes'},
        function() {
                    $('#modalWindow').modal('hide');
        });

    return false;

});

JS;

$this->registerJs($script);
