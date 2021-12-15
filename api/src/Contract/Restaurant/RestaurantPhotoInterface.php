<?php

namespace App\Contract\Restaurant;

interface RestaurantPhotoInterface
{
    public function getId(): int;
    public function getUrl(): string;
}
