<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class WebpackAsset extends AssetBundle
{
//    public $manifest = '@web/assets/manifest.json';

    public $basePath = '@webroot/assets/build';
    public $baseUrl = '@web/assets/build';
    public $css = [
        'app.css',
    ];
    public $js = [
        'runtime.js',
        'app.js'
    ];
}
