<?php

namespace backend\modules\student\assets;
use yii\web\AssetBundle;


class ProgramAsset  extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/program.js'
    ];
    public $depends = [
        'backend\assets\AppAsset', // after layout scripts
    ];

} 