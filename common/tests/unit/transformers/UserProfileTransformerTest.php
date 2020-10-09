<?php

namespace common\tests\unit\transformers;

use Codeception\Test\Unit;
use common\models\User;
use common\tests\fake\UserFake;
use common\transformers\UserProfileTransformer;

class UserProfileTransformerTest extends Unit
{
    /**
     * @dataProvider userProvider
     * @param User $user
     */
    public function testTransform(User $user): void
    {
        $transformer = new UserProfileTransformer();
        $array = $transformer->transform($user);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('email', $array);
        $this->assertArrayHasKey('rocketchat_id', $array);

        $this->assertEquals($user->id, $array['id']);
        $this->assertEquals($user->email, $array['email']);
        $this->assertEquals($user->rocketchat_id, $array['rocketchat_id']);
    }

    public function userProvider(): array
    {
        $user1 = new UserFake();
        $user2 = new UserFake();
        $user2->id = 3;
        $user2->email = 'test@example.com';
        $user2->rocketchat_id = '1234';


        return [
            [$user1],
            [$user2],
        ];
    }
}
