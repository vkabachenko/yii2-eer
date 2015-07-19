<!-- дополнение к grid/index -->

<!-- Additional  -->

<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\GridAsset;

GridAsset::register($this);
?>


<!-- functions for grid buttons actions -->
<?php


function actionUpdate($url,$model,$key) {
    $url = Url::to(['update','id' => $key]);
    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
        $url,[
            'class' => 'actionUpdate',
            'data-pjax' => '0',
        ]);
}

function actionDelete($url,$model,$key) {
    $url = Url::to(['delete','id' => $key]);
    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
        $url,[
            'class' => 'actionDelete',
            'data-pjax' => '0',
        ]);
}


// manage files. Not via ajax
function actionFile($url,$model,$key) {
    /* @var $model yii\db\ActiveRecord */
    $controller = strtr($model->tableName(),'_','-');
    $url = Url::to(["/file/$controller",'idParent' => $key]);
    return Html::a('<span class="glyphicon glyphicon-file"></span>',
        $url,[
            'class' => 'actionFile',
            'data-pjax' => '0',
        ]);
}
?>



