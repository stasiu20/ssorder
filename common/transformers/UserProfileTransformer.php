<?php

namespace common\transformers;

use common\models\User;
use League\Fractal\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{
    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'rocketchat_id' => $user->rocketchat_id,
        ];
    }
}
