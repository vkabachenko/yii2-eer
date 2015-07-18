<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class FilesAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/listFiles.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset', // after layout scripts
    ];
}
