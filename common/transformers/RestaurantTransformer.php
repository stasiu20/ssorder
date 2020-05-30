<?php

namespace common\transformers;

use frontend\helpers\FileServiceViewHelper;
use frontend\models\Restaurants;
use League\Fractal\TransformerAbstract;

class RestaurantTransformer extends TransformerAbstract
{
    /**
     * @param Restaurants $data
     * @return array
     */
    public function transform(Restaurants $data): array
    {
        return [
            'id' => $data->id,
            'name' => $data->restaurantName,
            'category' => $data->categoryId,
            'imageUrl' => null === $data->img_url ? null : FileServiceViewHelper::getRestaurantImageUrl($data->img_url),
            'packPrice' => $data->pack_price,
            'deliveryPrice' => $data->delivery_price,
            'telNumber' => $data->tel_number,
        ];
    }
}
