<?php

namespace common\resources;

use common\models\User;
use common\transformers\UserProfileTransformer;
use League\Fractal\Resource\Item;

class UserProfileResource
{
    public static function factoryItem(User $user): Item
    {
        return new Item($user, new UserProfileTransformer());
    }
}
