<?php

namespace common\models;

use yii\data\Sort;

class History
{
    public static function findByUser($userId)
    {

        return Order::find()->where(['userId' => $userId])
            ->andWhere(['status' => Order::STATUS_REALIZED]);
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
            ],
            'defaultOrder' => [
                'data' => SORT_DESC,
                'price' => SORT_ASC,
            ]
        ]);

        return $orderBy;
    }
}