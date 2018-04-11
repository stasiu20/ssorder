<?php

namespace frontend\models;

use yii\base\Model;

class OrderSummaryRow extends Model
{
    /** @var Restaurants */
    public $restaurant;

    /** @var float */
    public $price = 0.0;

    /** @var int */
    public $numOfOrders = 0;

    /** @var float */
    private $cost = 0.0;

    public $deliveryCost = 0.0;

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    public function setCost($cost)
    {
        $this->cost = floatval($cost);
        return $this;
    }

    public function getCostWithDelivery()
    {
        if ($this->numOfOrders > 0) {
            return $this->cost + $this->deliveryCost;
        }
        return 0.0;
    }
}
