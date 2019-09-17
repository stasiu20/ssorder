<?php

namespace frontend\assets;

use yii\helpers\Json;
use yii\web\AssetBundle;

class WebpackAsset extends AssetBundle
{
    /** @var string  */
    public $entryPointsFile = '@webroot/assets/build/entrypoints.json';
    /** @var string  */
    public $entryPoint = 'app';

    /** @var string  */
    public $basePath = '@webroot/assets/build';
    /** @var string  */
    public $baseUrl = '@web/assets/build';

    public function publish($am): void
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
