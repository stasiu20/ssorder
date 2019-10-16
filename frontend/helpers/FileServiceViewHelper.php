<?php

namespace frontend\helpers;

use common\services\FileService;

class FileServiceViewHelper
{
    public static function getPublicUrl(string $pathToFile): string
    {
        /** @var FileService $fileService */
        $fileService = \Yii::$container->get(FileService::class);
        return $fileService->getPublicFileUrl($pathToFile);
    }

    public static function getRestaurantImageUrl(string $imageUrl): string
    {
        return self::getPublicUrl(self::getRestaurantImageKey($imageUrl));
    }

    public static function getMenuImageUrl(string $imageUrl): string
    {
        return self::getPublicUrl(self::getMenuImageKey($imageUrl));
    }

    public static function getRestaurantImageKey(string $imageUrl): string
    {
        return '/restaurants/' . $imageUrl;
    }

    public static function getMenuImageKey(string $imageUrl): string
    {
        return '/menus/' . $imageUrl;
    }
}
