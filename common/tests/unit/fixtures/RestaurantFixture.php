<?php

namespace common\tests\unit\fixtures;

use frontend\models\Restaurants;
use yii\test\ActiveFixture;

class RestaurantFixture extends ActiveFixture
{
    public $modelClass = Restaurants::class;
    public $depends = [CategoryFixture::class];

    public function beforeLoad()
    {
        parent::beforeLoad();
        $GLOBALS['fixtures'][static::class] = $this;
    }
}
