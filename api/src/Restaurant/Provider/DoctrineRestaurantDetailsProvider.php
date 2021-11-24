<?php

namespace App\Restaurant\Provider;

use App\Contract\Restaurant\RestaurantDetailsInterface;
use App\Contract\Restaurant\RestaurantDetailsProviderInterface;
use App\File\FileService;
use App\Restaurant\Dto\RestaurantDetailsDto;
use App\Restaurant\Dto\RestaurantMenuItemDto;
use App\Restaurant\Entity\MenuPosition;
use App\Restaurant\Entity\Restaurant;
use App\Restaurant\Exception\RestaurantNotFoundException;
use App\Restaurant\Repository\RestaurantRepository;
use Money\Money;

class DoctrineRestaurantDetailsProvider implements RestaurantDetailsProviderInterface
{
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;
    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(RestaurantRepository $restaurantRepository, FileService $fileService)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->fileService = $fileService;
    }

    public function getDetails(int $restaurantId): RestaurantDetailsInterface
    {
        $restaurant = $this->restaurantRepository->find($restaurantId);

        if (null === $restaurant) {
            throw RestaurantNotFoundException::restaurantNotExists($restaurantId);
        }

        $dto = new RestaurantDetailsDto();
        $dto->setPackPrice(Money::PLN($this->convertToCents($restaurant->getPackPrice() ?? '0')));
        $dto->setDeliveryPrice(Money::PLN($this->convertToCents($restaurant->getDeliveryPrice() ?? '0')));
        $dto->setPhoneNumber($restaurant->getPhoneNumber());
        $dto->setName($restaurant->getName());
        $dto->setId($restaurant->getId());
        $dto->setLogoUrl($this->getRestaurantLogo($restaurant));

        $menu = $restaurant->getMenu()->map(function (MenuPosition $menuPosition) {
            $menuItemDto = new RestaurantMenuItemDto();

            $menuItemDto->setPrice(Money::PLN($this->convertToCents($menuPosition->getFoodPrice() ?? '0')));
            $menuItemDto->setId($menuPosition->getId());
            $menuItemDto->setDescription($menuPosition->getFoodInfo());
            $menuItemDto->setName($menuPosition->getFoodName());

            return $menuItemDto;
        })->toArray();
        $dto->setMenu($menu);

        return $dto;
    }

    private function convertToCents(string $amount): int
    {
        return (int) ((float) preg_replace('/[^\d\.]/', '', $amount) * 100);
    }

    private function getRestaurantLogo(Restaurant $restaurant): ?string
    {
        if (empty($restaurant->getImgUrl())) {
            return null;
        }

        return $this->fileService->getRestaurantImageUrl($restaurant->getImgUrl());
    }
}
