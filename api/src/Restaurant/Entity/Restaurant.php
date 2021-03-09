<?php

namespace App\Restaurant\Entity;

use App\Restaurant\Repository\RestaurantRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 * @ORM\Table(name="restaurants")
 */
class Restaurant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, name="restaurantName")
     *
     * @var string
     */
    private $name;

    /**
     *
     * @ORM\Column(name="tel_number", type="string", length=12, nullable=false)
     *
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivery_price", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $deliveryPrice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pack_price", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $packPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="img_url", type="string", length=300, nullable=false)
     */
    private $imgUrl = '';

    /**
     * @var int
     *
     * @ORM\Column(name="categoryId", type="integer", nullable=false)
     */
    private $categoryId;

    /**
     * @var DateTimeImmutable|null
     *
     * @ORM\Column(name="deletedAt", type="datetime_immutable", nullable=true)
     */
    private $deletedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getDeliveryPrice(): ?string
    {
        return $this->deliveryPrice;
    }

    /**
     * @return string|null
     */
    public function getPackPrice(): ?string
    {
        return $this->packPrice;
    }

    /**
     * @return string
     */
    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
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
     * @param string|null $deliveryPrice
     */
    public function setDeliveryPrice(?string $deliveryPrice): void
    {
        $this->deliveryPrice = $deliveryPrice;
    }

    /**
     * @param string|null $packPrice
     */
    public function setPackPrice(?string $packPrice): void
    {
        $this->packPrice = $packPrice;
    }

    /**
     * @param string $imgUrl
     */
    public function setImgUrl(string $imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function isActive(): bool
    {
        return null === $this->deletedAt;
    }
}