<?php

namespace frontend\modules\apiV1\factory;

use frontend\modules\apiV1\models\MenuItem;
use frontend\modules\apiV1\models\Money;
use frontend\modules\apiV1\models\RestaurantDetails;
use frontend\modules\apiV1\models\RestaurantPhoto;

class RestaurantDetailsFactory
{
    public function factoryRestaurantDetails(array $details): RestaurantDetails
    {
        $model = new RestaurantDetails();
        $model->id = $details['id'];
        $model->name = $details['name'];
        $model->phoneNumber = $details['phone_number'];
        $model->logoUrl = $details['logo_url'];
        $model->deliveryPrice = new Money();
        $model->deliveryPrice->amount = $details['delivery_price']['amount'];
        $model->deliveryPrice->currency = $details['delivery_price']['currency'];
        $model->packPrice = new Money();
        $model->packPrice->amount = $details['pack_price']['amount'];
        $model->packPrice->currency = $details['pack_price']['currency'];
        $model->menu = array_map(static function ($menu) {
            $item = new MenuItem();
            $item->id = $menu['id'];
            $item->name = $menu['name'];
            $item->description = $menu['description'];
            $item->price = new Money();
            $item->price->currency = $menu['price']['currency'];
            $item->price->amount = $menu['price']['amount'];

            return $item;
        }, $details['menu']);

        $model->photos = array_map(static function ($photo) {
            $item = new RestaurantPhoto();
            $item->id = $photo['id'];
            $item->url = $photo['url'];

            return $item;
        }, $details['photos']);

        return $model;
    }
}
