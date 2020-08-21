<?php

namespace common\transformers;

use frontend\models\Category;
use League\Fractal\TransformerAbstract;

class DictCategoryTransformer extends TransformerAbstract
{
    /**
     * @param Category $data
     * @return array
     */
    public function transform(Category $data): array
    {
        return [
            'id' => $data->id,
            'name' => $data->categoryName,
        ];
    }
}
