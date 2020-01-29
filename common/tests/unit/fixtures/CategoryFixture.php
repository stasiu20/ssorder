<?php

namespace common\tests\unit\fixtures;

use common\services\FixtureStore;
use frontend\models\Category;
use yii\test\ActiveFixture;

class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;

    public function beforeLoad(): void
    {
        parent::beforeLoad();
        FixtureStore::getInstance()->addFixture($this);
    }
}
