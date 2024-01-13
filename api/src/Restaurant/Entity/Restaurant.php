<?php

namespace App\Restaurant\Entity;

use App\Restaurant\Repository\RestaurantRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 * @ORM\Table(name="restaurants")
 */
class Restaurant implements NormalizableInterface
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

    /**
     * @var Collection<MenuPosition>
     *
     * @ORM\OneToMany(targetEntity=MenuPosition::class, mappedBy="restaurant", orphanRemoval=true)
     */
    private $menu;

    /**
     * @var Collection<Photo>
     *
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="restaurant", orphanRemoval=true)
     */
    private $photos;

    public function __construct()
    {
        $this->menu = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, MenuPosition>
     */
    public function getMenu(): Collection
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->isNull('deletedat'));

        return $this->menu->matching($criteria);
    }

    public function addMenu(MenuPosition $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
            $menu->setRestaurant($this);
        }

        return $this;
    }

    public function removeMenu(MenuPosition $menu): self
    {
        if ($this->menu->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getRestaurant() === $this) {
                $menu->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->isNull('deletedAt'));

        return $this->photos->matching($criteria);
    }

    /**
     * @param NormalizerInterface $normalizer
     * @param string|null         $format
     * @param array<mixed> $context
     *
     * @return array{
     *     objectID: string,
     *     type: string,
     *     food: null,
     *     restaurant: array{
     *         id: int,
     *         name: string
     *     },
     *     restaurant_name_search: string,
     *     food_name_search: null
     * }
     */
    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = []): array
    {
        return [
            'objectID' => 'restaurant-' . $this->getId(),
            'type' => 'restaurant',
            'food' => null,
            'restaurant' => [
                'id' => $this->getId(),
                'name' => $this->getName(),
            ],
            'restaurant_name_search' => $this->getName(),
            'food_name_search' => null,
        ];
    }
}
