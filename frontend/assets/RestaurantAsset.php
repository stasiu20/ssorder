<?php

namespace frontend\assets;

class RestaurantAsset extends WebpackAsset
{
    public $entryPoint = 'restaurant';
    public $depends = [
        WebpackAsset::class,
    ];
}
