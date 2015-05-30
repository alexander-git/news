<?php

namespace app\assets;

use yii\web\AssetBundle;

class NewsListAsset extends AssetBundle
{
    public $basePath = '@webroot/css/items';
    public $baseUrl = '@web/css/items';
    
    public $css = [
        'newsList.css',
    ];

}