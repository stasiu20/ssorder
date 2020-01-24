<?php
namespace common\tests\unit\fixtures;

use common\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;

    public function beforeLoad()
    {
        parent::beforeLoad();
        $GLOBALS['fixtures'][static::class] = $this;
    }
}
