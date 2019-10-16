<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Class OrderSummaryRow
 * @package frontend\models
 *
 * @property float $cost
 * @property-read float $change
 */
class OrderSummaryRow extends Model
{
    /** @var Restaurants */
    public $restaurant;

    /** @var float */
    public $price = 0.0;

    /**
     * @var int
     * @deprecated Use numOfRealizedOrders
     * @see \frontend\models\OrderSummaryRow::$numOfRealizedOrders
     */
    public $numOfOrders = 0;

    /** @var int  */
    public $numOfRealizedOrders = 0;

    /** @var float */
    private $_cost = 0.0;

    /** @var float */
    public $deliveryCost = 0.0;

    /** @var float */
    public $pay_amount = 0.0;

    /** @var int */
    public $allOrders = 0;

    public function getCost(): float
    {
        return $this->_cost;
    }

    /**
     * @param mixed $cost
     * @return $this
     */
    public function setCost($cost)
    {
        $this->_cost = floatval($cost);
        return $this;
    }

    public function getCostWithDelivery(): float
    {
        if ($this->numOfRealizedOrders > 0) {
            return $this->_cost + $this->deliveryCost;
        }
        return 0.0;
    }

    public function getChange(): ?float
    {
        if ($this->numOfRealizedOrders > 0) {
            return $this->getCostWithDelivery() - $this->pay_amount;
        }

        return null;
    }
}
