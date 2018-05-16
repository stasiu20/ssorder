<?php

namespace common\models;

use yii\data\Sort;

class History
{
    public static function findByUser($userId)
    {
        $filters = new OrderFilters();
        $filters->status = Order::STATUS_REALIZED;
        $filters->userId = $userId;
        return OrderSearch::search($filters);
    }

    public static function getDefaultSort()
    {
        $orderBy = new Sort([
            'attributes' => [
                'data',
                'price' => [
                    'asc' => ['price' => SORT_ASC, 'data' => SORT_DESC],
                    'desc' => ['price' => SORT_DESC, 'data' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => \Yii::t('app', 'Price'),
                ],
                'user.username'
            ],
            'defaultOrder' => [
                'data' => SORT_DESC,
                'price' => SORT_ASC,
            ]
        ]);

        return $orderBy;
    }
}