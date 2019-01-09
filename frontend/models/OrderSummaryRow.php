<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Class OrderSummaryRow
 * @package frontend\models
 *
 * @property-read float $change
 */
class OrderSummaryRow extends Model
{
    /** @var Restaurants */
    public $restaurant;

    /** @var float */
    public $price = 0.0;

    /** @var int */
    public $numOfOrders = 0;

    /** @var float */
    private $_cost = 0.0;

    public $deliveryCost = 0.0;

    public $pay_amount = 0.0;

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->_cost;
    }

    public function setCost($cost)
    {
        $this->_cost = floatval($cost);
        return $this;
    }

    public function getCostWithDelivery()
    {
        if ($this->numOfOrders > 0) {
            return $this->_cost + $this->deliveryCost;
        }
        return 0.0;
    }

    public function getChange()
    {
        if ($this->numOfOrders > 0) {
            return $this->getCostWithDelivery() - $this->pay_amount;
        }

        return null;
    }
}
