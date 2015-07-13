<?php

/* @var $faculty Faculty */

use frontend\modules\program\helpers\AccordionContent;
use yii\jui\Accordion;
use yii\helpers\Html;
use frontend\modules\program\assets\AccordionAsset;
use common\models\Faculty;
use yii\bootstrap\Modal;

AccordionAsset::register($this);

$this->title = 'Образовательные программы';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h2',$this->title);
echo Html::tag('h3','Факультет: '.$faculty->name);

    $accordion = new AccordionContent();
    $items = $accordion->items($faculty->id);

if (count($items) == 0) {
    echo Html::tag('p','Нет образовательных программ');
}
else {

    echo Accordion::widget([
         'items' => $items,
         'clientOptions' => [
            'event' => 'mouseover'
         ],
         'options' => [
             'id' => 'accordionContainer'
         ]
         ]);
}


// Modal window declaration
Modal::begin([
    'id' => 'modalWindow',
    'header' => '<h2>Документы</h2>',
]);

Modal::end();
