<?php

namespace app\assets;

use yii\web\AssetBundle;

class CommonCssAsset extends AssetBundle
{
    public $basePath = '@webroot/css/common';
    public $baseUrl = '@web/css/common';
    
    public $css = [
        'control.css',
        'decoration.css'
    ];

}