<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ResetFileInputAsset extends AssetBundle
{
    public $basePath = '@webroot/js/items/resetFileInput';
    public $baseUrl = '@web/js/items/resetFileInput';
    
    public $js = [
        'ResetFileInput.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
     
}
