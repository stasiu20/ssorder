<?php

namespace common\transformers;

use frontend\models\Restaurants;

class RestaurantCollectionTransformer implements Transformer
{
    /**
     * @param Restaurants[] $data
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function transform($data): array
    {
        $result = [];
        /** @var RestaurantTransformer $transformer */
        $transformer = \Yii::$container->get(RestaurantTransformer::class);
        foreach ($data as $restaurant) {
            $result[] = $transformer->transform($restaurant);
        }
        return $result;
    }
}
