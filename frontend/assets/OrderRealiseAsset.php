<?php

namespace frontend\assets;

class OrderRealiseAsset extends WebpackAsset
{
    public $entryPoint = 'orderRealise';
    public $depends = [
        WebpackAsset::class,
    ];
}
