<?php

namespace App\Api\Transformer;

use App\File\FileService;
use App\Restaurant\Entity\Restaurant;
use League\Fractal\TransformerAbstract;

class RestaurantTransformer extends TransformerAbstract
{
    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param Restaurant $data
     *
     * @return array{
     *   id: int,
     *   name: string,
     *   category: int,
     *   imageUrl: string|null,
     *   packPrice: float,
     *   deliveryPrice: float,
     *   telNumber: string
     * }
     */
    public function transform(Restaurant $data): array
    {
        return [
            'id' => $data->getId(),
            'name' => $data->getName(),
            'category' => $data->getCategoryId(),
            'imageUrl' => $this->getImageUrl($data),
            'packPrice' => (float) $data->getPackPrice(),
            'deliveryPrice' => (float) $data->getDeliveryPrice(),
            'telNumber' => $data->getPhoneNumber(),
        ];
    }

    private function getImageUrl(Restaurant $data): ?string
    {
        return empty($data->getImgUrl()) ? null : $this->fileService->getRestaurantImageUrl($data->getImgUrl());
    }
}
