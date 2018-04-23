<?php

namespace common\models;

class History
{
    public static function findByUser($userId)
    {
        return Order::find()->where(['userId' => $userId])
            ->andWhere(['status' => Order::STATUS_REALIZED])
            ->orderBy('data DESC');
    }
}