<?php

namespace common\models;

class OrderSearch extends Order
{
    public static function search(OrderFilters $filters)
    {
        $query =  Order::find();
        $userTableName = self::getDb()->getSchema()->getRawTableName(User::tableName());
        $query->joinWith($userTableName);
        if ($filters->userId) {
            $query->andWhere(['userId' => $filters->userId]);
        }

        if ($filters->restaurantId) {
            $query->andWhere(['order.restaurantId' => $filters->restaurantId]);
        }

        if (null !== $filters->status) {
            $query->andWhere(['order.status' => $filters->status]);
        }

        if ($filters->dateFrom) {
            $query->andWhere(['>=', 'data', $filters->dateFrom]);
        }

        if ($filters->dateTo) {
            $query->andWhere(['<', 'data', $filters->dateTo]);
        }

        if ($filters->realizedBy) {
            $query->andWhere(['realizedBy' => $filters->realizedBy]);
        }

        return $query;
    }
}
