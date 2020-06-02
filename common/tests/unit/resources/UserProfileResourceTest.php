<?php

namespace common\tests\unit\resources;

use Codeception\Test\Unit;
use common\models\User;
use common\resources\UserProfileResource;
use League\Fractal\Resource\Item;

class UserProfileResourceTest extends Unit
{
    public function testFactoryItem(): void
    {
        $user = new User();
        $resource = UserProfileResource::factoryItem($user);
        $this->assertInstanceOf(Item::class, $resource);
    }
}
