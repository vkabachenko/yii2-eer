<?php

namespace backend\assets;

use yii\web\AssetBundle;


class GridAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/grid.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
