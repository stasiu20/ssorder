<?php

namespace common\tests\unit\fixtures;

use frontend\models\Category;
use yii\test\ActiveFixture;

class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;

    public function beforeLoad()
    {
        parent::beforeLoad();
        $GLOBALS['fixtures'][static::class] = $this;
    }
}
