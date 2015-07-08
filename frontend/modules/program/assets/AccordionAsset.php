<?php

namespace frontend\modules\program\assets;

use yii\web\AssetBundle;


class AccordionAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [

    ];
    public $css = [
        'css/accordion.css'
    ];
    public $depends = [
        'frontend\assets\AppAsset', // after layout scripts
    ];
}
