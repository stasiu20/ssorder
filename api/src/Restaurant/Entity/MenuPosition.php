<?php

namespace App\Restaurant\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity
 */
class MenuPosition implements NormalizableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="foodName", type="string", length=200, nullable=false)
     */
    private $foodname;

    /**
     * @var string
     *
     * @ORM\Column(name="foodInfo", type="text", length=65535, nullable=false)
     */
    private $foodinfo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="foodPrice", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $foodprice;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedat;

    /**
     * @var Restaurant|null
     *
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="menu")
     * @ORM\JoinColumn(name="restaurantId", nullable=false)
     */
    private $restaurant;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getRestaurantId(): ?int
    {
        return $this->getRestaurant()->getId();
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * @return string
     */
    public function getFoodName(): string
    {
        return $this->foodname;
    }

    /**
     * @param string $foodName
     */
    public function setFoodName(string $foodName): void
    {
        $this->foodname = $foodName;
    }

    /**
     * @return string
     */
    public function getFoodInfo(): string
    {
        return $this->foodinfo;
    }

    /**
     * @param string $foodInfo
     */
    public function setFoodInfo(string $foodInfo): void
    {
        $this->foodinfo = $foodInfo;
    }

    /**
     * @return string|null
     */
    public function getFoodPrice(): ?string
    {
        return $this->foodprice;
    }

    /**
     * @param string|null $foodPrice
     */
    public function setFoodPrice(?string $foodPrice): void
    {
        $this->foodprice = $foodPrice;
    }

    public function isActive(): bool
    {
        return null === $this->deletedat;
    }

    /**
     * @phpstan-ignore-next-line
     *
     * @param NormalizerInterface $normalizer
     * @param string|null         $format
     * @param array               $context
     *
     * @return array
     */
    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = []): array
    {
        $restaurant = $this->getRestaurant();

        if ($restaurant) {
            $restaurantData = [
                'id' => $restaurant->getId(),
                'name' => $restaurant->getName(),
            ];
        } else {
            $restaurantData = null;
        }

        return [
            'objectID' => 'menu-' . $this->getId(),
            'type' => 'food',
            'food' => [
                'id' => $this->getId(),
                'name' => $this->getFoodName(),
                'price' => $this->getFoodPrice(),
                'info' => $this->getFoodInfo(),
            ],
            'restaurant' => $restaurantData,
            'restaurant_name_search' => $restaurantData ? $restaurantData['name'] : null,
            'food_name_search' => $this->getFoodName(),
        ];
    }
}
