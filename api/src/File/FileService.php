<?php

namespace App\File;

use GuzzleHttp\Psr7\Uri;

class FileService
{
    /** @var string */
    private $bucketName = '/ssorder';
    /**
     * @var string
     */
    private $publicUrl;

    public function __construct(string $publicUrl)
    {
        $this->publicUrl = $publicUrl;
    }

    public function getRestaurantImageUrl(string $imageUrl): string
    {
        return $this->getPublicFileUrl('/restaurants/' . $imageUrl);
    }

    private function getPublicFileUrl(string $key): string
    {
        $uri = new Uri($this->publicUrl);
        $uri = $uri->withPath($this->bucketName . '/' . $key);

        return (string) $uri;
    }
}
