<?php
namespace common\tests\unit\fixtures;

use common\models\User;
use common\services\FixtureStore;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;

    public function beforeLoad(): void
    {
        parent::beforeLoad();
        FixtureStore::getInstance()->addFixture($this);
    }
}
