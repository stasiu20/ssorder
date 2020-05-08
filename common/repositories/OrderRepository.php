<?php

namespace common\repositories;

use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use frontend\services\OrderSummaryStatics;
use Tightenco\Collect\Support\Collection;

class OrderRepository
{
    public function ordersByRestaurantWithStats(OrderFilters $filters): array
    {
        $model = OrderSearch::search($filters)->all();

        $collection = new Collection($model);
        $orders = $collection->groupBy(function (Order $order) {
            return $order->restaurantId;
        })->toArray();

        $statics = new OrderSummaryStatics();
        $summary = $statics->getStatics($model);

        return [$orders, $summary];
    }
}
