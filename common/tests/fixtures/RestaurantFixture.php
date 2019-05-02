<?php

namespace common\tests\fixtures;

use frontend\models\Restaurants;
use yii\test\ActiveFixture;

class RestaurantFixture extends ActiveFixture
{
    public $modelClass = Restaurants::class;
    public $depends = [CategoryFixture::class];
}
