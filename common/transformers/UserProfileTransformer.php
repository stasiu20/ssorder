<?php

namespace common\transformers;

use common\models\User;

class UserProfileTransformer implements Transformer
{
    /**
     * @param User $data
     * @return array
     */
    public function transform($data): array
    {
        return $data->toArray(['email', 'rocketchat_id']);
    }
}
