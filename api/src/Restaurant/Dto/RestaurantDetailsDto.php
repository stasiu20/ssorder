<?php

namespace App\Restaurant\Dto;

use App\Contract\Restaurant\RestaurantDetailsInterface;
use App\Contract\Restaurant\RestaurantMenuItemInterface;
use App\Contract\Restaurant\RestaurantPhotoInterface;
use Money\Money;

class RestaurantDetailsDto implements RestaurantDetailsInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $phoneNumber;

    /** @var Money */
    private $deliveryPrice;

    /** @var Money */
    private $packPrice;

    /** @var string */
    private $logoUrl;

    /** @var RestaurantMenuItemInterface[] */
    private $menu;

    /** @var RestaurantPhotoInterface[] */
    private $photos;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getDeliveryPrice(): Money
    {
        return $this->deliveryPrice;
    }

    public function getPackPrice(): Money
    {
        return $this->packPrice;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function getMenu(): array
    {
        return $this->menu;
    }

    /**
     * @return RestaurantPhotoInterface[]
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @param Money $deliveryPrice
     */
    public function setDeliveryPrice(Money $deliveryPrice): void
    {
        $this->deliveryPrice = $deliveryPrice;
    }

    /**
     * @param Money $packPrice
     */
    public function setPackPrice(Money $packPrice): void
    {
        $this->packPrice = $packPrice;
    }

    /**
     * @param string $logoUrl
     */
    public function setLogoUrl(string $logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    /**
     * @param RestaurantMenuItemInterface[] $menu
     */
    public function setMenu(array $menu): void
    {
        $this->menu = $menu;
    }

    /**
     * @param RestaurantPhotoInterface[] $photos
     */
    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }
}
