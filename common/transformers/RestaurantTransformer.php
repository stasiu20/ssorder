<?php

namespace common\transformers;

use frontend\helpers\FileServiceViewHelper;
use frontend\models\Restaurants;

class RestaurantTransformer implements Transformer
{
    /**
     * @param Restaurants $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id' => $data->id,
            'name' => $data->restaurantName,
            'category' => $data->categoryId,
            'imageUrl' => FileServiceViewHelper::getRestaurantImageUrl($data->img_url),
            'packPrice' => $data->pack_price,
            'deliveryPrice' => $data->delivery_price,
            'telNumber' => $data->tel_number,
        ];
    }
}
