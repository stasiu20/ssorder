<?php

namespace frontend\assets;

class ProfileAsset extends WebpackAsset
{
    public $entryPoint = 'profile';
    public $depends = [
        WebpackAsset::class,
    ];
}
