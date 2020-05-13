<?php

namespace common\services\actions;

use common\enums\BucketEnum;
use common\services\FileService;
use frontend\helpers\FileServiceViewHelper;
use frontend\models\Restaurants;
use yii\web\UploadedFile;

class UploadRestaurantLogo
{
    /**
     * @var FileService
     */
    private $_fileService;

    public function __construct(FileService $fileService)
    {
        $this->_fileService = $fileService;
    }

    public function run(Restaurants $restaurant, UploadedFile $uploadedFile): void
    {
        $restaurant->scenario = Restaurants::SCENARIO_UPLOAD;
        $restaurant->imageFile = $uploadedFile;
        $key = $restaurant->getTmpFileKey();
        $oldImgUrl = $restaurant->img_url;
        $restaurant->img_url = $key;
        if ($restaurant->validate()) {
            $this->_fileService->storeFile(
                BucketEnum::RESTAURANT . '/' . $key,
                $restaurant->imageFile->tempName
            );
            if (!empty($oldImgUrl)) {
                $this->_fileService->deleteFile(
                    FileServiceViewHelper::getRestaurantImageKey($oldImgUrl)
                );
            }
        }
    }
}
