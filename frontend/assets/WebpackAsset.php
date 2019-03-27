<?php

namespace frontend\assets;

use yii\helpers\Json;
use yii\web\AssetBundle;

class WebpackAsset extends AssetBundle
{
    public $entryPointsFile = '@webroot/assets/build/entrypoints.json';
    public $entryPoint = 'app';

    public $basePath = '@webroot/assets/build';
    public $baseUrl = '@web/assets/build';

    public function publish($am)
    {
        $path = \Yii::getAlias($this->entryPointsFile);
        $content = file_get_contents($path);
        $entryPoints = Json::decode($content);


        $data = $entryPoints['entrypoints'][$this->entryPoint];
        if (isset($data['js']) && is_array($data['js'])) {
            $this->js = $data['js'];
        }

        if (isset($data['css']) && is_array($data['css'])) {
            $this->css = $data['css'];
        }

        parent::publish($am);
    }
}
