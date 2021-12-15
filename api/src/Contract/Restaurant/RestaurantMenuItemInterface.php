<?php

namespace App\Contract\Restaurant;

use Money\Money;

interface RestaurantMenuItemInterface
{
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): string;
    public function getPrice(): Money;
}
