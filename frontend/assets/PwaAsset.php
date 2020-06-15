<?php

namespace frontend\assets;

class PwaAsset extends WebpackAsset
{
    public $entryPoint = 'pwa';
    public $depends = [
        WebpackAsset::class,
    ];
}
