<?php

namespace App\Contract\Restaurant;

use Money\Money;

interface RestaurantDetailsInterface
{
    public function getId(): int;
    public function getName(): string;
    public function getPhoneNumber(): string;
    public function getDeliveryPrice(): Money;
    public function getPackPrice(): Money;
    public function getLogoUrl(): ?string;

    /**
     * @return RestaurantMenuItemInterface[]
     */
    public function getMenu(): array;

    /**
     * @return RestaurantPhotoInterface[]
     */
    public function getPhotos(): array;
}
