<?php

namespace frontend\models;

class OrdersSummary
{
    /** @var OrderSummaryRow[] */
    private $_data = [];

    public function getData()
    {
        return $this->_data;
    }

    public function setData(array $data)
    {
        foreach ($data as $restaurantId => $summary) {
            $this->setRestaurantStatics($restaurantId, $summary);
        }
    }

    public function setRestaurantStatics($restaurantId, OrderSummaryRow $summaryRow)
    {
        $this->_data[$restaurantId] = $summaryRow;
    }

    public function getDataForRestaurant($restaurantId)
    {
        if (isset($this->_data[$restaurantId])) {
            return $this->_data[$restaurantId];
        }

        throw new \OutOfBoundsException(sprintf('Restaurant "%s" not exist', $restaurantId));
    }
}
