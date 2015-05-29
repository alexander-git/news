<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FileControlAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/items/fileControl.css'
    ];
    
    public $js = [
        'js/items/fileControl/FileControlSelectors.js',
        'js/items/fileControl/FileControl.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
   
}
