<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/** @var $provider yii\data\ActiveDataProvider */
/* @var $title string */
/* @var $images[] string */

$this->title = 'Факультеты';
echo Html::tag('h2 class="injumb"',$this->title);
?>

    <?= ListView::widget([
        'dataProvider' => $provider,
        'itemView' => '_faculty',
        'summary' => '',
        'options' => ['id' => 'facultyList',],
        'itemOptions' => ['class' => 'faculty',]
    ]); ?>

<?php

$images = json_encode($images);

$script =
    <<<JS

    var images = $images;

    $('div.faculty').each(function(){

        var div = $(this);
        var key = div.data('key');
        if (key in images) {
            div.find('a').css('backgroundImage','url(../files/' + images[key] + ')');
        }
    });

JS;
$this->registerJs($script);
