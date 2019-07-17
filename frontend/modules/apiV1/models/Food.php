<?php

namespace frontend\modules\apiV1\models;

use frontend\models\Menu;

class Food extends Menu
{
    public function fields()
    {
        return [
            'id',
            'restaurantId',
            'foodName',
            'foodInfo',
            'foodPrice' => function (Food $model) {
                return (float)$model->foodPrice;
            },
        ];
    }
}
