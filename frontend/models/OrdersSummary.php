<?php

namespace frontend\models;

class OrdersSummary
{
    /** @var OrderSummaryRow[] */
    private $data = [];

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        foreach ($data as $restaurantId => $summary) {
            $this->setRestaurantStatics($restaurantId, $summary);
        }
    }

    public function setRestaurantStatics($restaurantId, OrderSummaryRow $summaryRow)
    {
        $this->data[$restaurantId] = $summaryRow;
    }

    public function getDataForRestaurant($restaurantId)
    {
        if (isset($this->data[$restaurantId])) {
            return $this->data[$restaurantId];
        }

        throw new \OutOfBoundsException(sprintf('Restaurant "%s" not exist', $restaurantId));
    }
}