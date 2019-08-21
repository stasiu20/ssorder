<?php

namespace frontend\modules\apiV1\models;

use frontend\models\Restaurants;

class Restaurant extends Restaurants
{
    public function fields()
    {
        return [
            'id',
            'restaurantName',
            'phoneNumber' => 'tel_number',
            'deliveryPrice' => function (Restaurant $model) {
                return (float)$model->delivery_price;
            },
            'packPrice' => function (Restaurant $model) {
                return (float)$model->pack_price;
            },
            'imgUrl' => 'img_url',
            'categoryId',
        ];
    }
}
