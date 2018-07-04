<?php

namespace common\models;

use yii\base\Model;

class OrderFilters extends Model
{
    public $restaurantId;
    public $userId;
    public $dateFrom;
    public $dateTo;
    public $status;
    public $realizedBy;
}
