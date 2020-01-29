<?php

namespace common\tests\unit\fixtures;

use common\services\FixtureStore;
use frontend\models\Menu;
use yii\test\ActiveFixture;

class MenuFixture extends ActiveFixture
{
    public $modelClass = Menu::class;
    public $depends = [RestaurantFixture::class];

    public function beforeLoad(): void
    {
        parent::beforeLoad();
        FixtureStore::getInstance()->addFixture($this);
    }
}
