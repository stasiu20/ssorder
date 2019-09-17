<?php

namespace frontend\models;

class OrdersSummary
{
    /** @var OrderSummaryRow[] */
    private $_data = [];

    /**
     * @return OrderSummaryRow[]
     */
    public function getData()
    {
        return $this->_data;
    }

    public function setData(array $data): void
    {
        foreach ($data as $restaurantId => $summary) {
            $this->setRestaurantStatics($restaurantId, $summary);
        }
    }

    public function setRestaurantStatics(int $restaurantId, OrderSummaryRow $summaryRow): void
    {
        $this->_data[$restaurantId] = $summaryRow;
    }

    public function getDataForRestaurant(int $restaurantId): OrderSummaryRow
    {
        if (isset($this->_data[$restaurantId])) {
            return $this->_data[$restaurantId];
        }

        throw new \OutOfBoundsException(sprintf('Restaurant "%s" not exist', $restaurantId));
    }
}
