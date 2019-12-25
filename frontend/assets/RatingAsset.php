<?php

namespace frontend\assets;

class RatingAsset extends WebpackAsset
{
    public $entryPoint = 'rating';
    public $depends = [
        WebpackAsset::class,
    ];
}
