<?php

namespace app\assets;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $basePath = '@webroot/css/';
    public $baseUrl = '@web/css/';
    
    public $css = [
        'main.css',
    ];

}