<?php

namespace common\models;

use yii\db\ActiveQuery;

class OrderSearch extends Order
{
    public static function search(OrderFilters $filters): ActiveQuery
    {
        $query =  Order::find();
        $userTableName = self::getDb()->getSchema()->getRawTableName(User::tableName());
        $query->joinWith($userTableName);
        $query->joinWith('menu');

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

        if ($filters->foodName) {
            $query->andFilterWhere(['like', 'menu.foodName', $filters->foodName]);
        }

        if ($filters->foodId) {
            $query->andWhere(['menu.id' => $filters->foodId]);
        }

        $query->andWhere(['is', 'order.deletedAt', null]);

        return $query;
    }
}
