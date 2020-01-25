<?php

namespace common\tests\unit\fixtures;

use common\services\FixtureStore;
use frontend\models\Restaurants;
use yii\test\ActiveFixture;

class RestaurantFixture extends ActiveFixture
{
    public $modelClass = Restaurants::class;
    public $depends = [CategoryFixture::class];

    public function beforeLoad(): void
    {
        parent::beforeLoad();
        FixtureStore::getInstance()->addFixture($this);
    }
}
