<?php

namespace frontend\assets;

use yii\web\JqueryAsset;

class PwaAsset extends WebpackAsset
{
    /** @var string  */
    public $entryPointsFile = '@webroot/assets/pwa/entrypoints.json';
    /** @var string  */
    public $entryPoint = 'app';

    /** @var string  */
    public $basePath = '@webroot/assets/pwa';
    /** @var string  */
    public $baseUrl = '@web/assets/pwa';

    public $depends = [
        JqueryAsset::class
    ];
}
