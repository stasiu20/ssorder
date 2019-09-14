<?php

namespace frontend\helpers;

use common\services\FileService;

class FileServiceViewHelper
{
    public static function getPublicUrl($pathToFile)
    {
        /** @var FileService $fileService */
        $fileService = \Yii::$container->get(FileService::class);
        return $fileService->getPublicFileUrl($pathToFile);
    }

    public static function getRestaurantImageUrl($imageUrl)
    {
        return self::getPublicUrl(self::getRestaurantImageKey($imageUrl));
    }

    public static function getMenuImageUrl($imageUrl)
    {
        return self::getPublicUrl(self::getMenuImageKey($imageUrl));
    }

    public static function getRestaurantImageKey($imageUrl)
    {
        return '/restaurants/' . $imageUrl;
    }

    public static function getMenuImageKey($imageUrl)
    {
        return '/menus/' . $imageUrl;
    }
}
