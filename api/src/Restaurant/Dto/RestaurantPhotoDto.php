<?php

namespace App\Restaurant\Dto;

use App\Contract\Restaurant\RestaurantPhotoInterface;

class RestaurantPhotoDto implements RestaurantPhotoInterface
{
    /** @var int */
    private $id;
    /** @var string */
    private $url;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
