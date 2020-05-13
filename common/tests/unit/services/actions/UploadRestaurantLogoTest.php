<?php

namespace common\tests\unit\services\actions;

use common\enums\BucketEnum;
use common\services\actions\UploadRestaurantLogo;
use common\services\FileService;
use frontend\models\Restaurants;
use yii\web\UploadedFile;

class UploadRestaurantLogoTest extends \Codeception\Test\Unit
{
    public function testUpload(): void
    {
        $fileTmpName = __DIR__ . '/../../../_data/file.png';

        /** @var FileService $fileServiceMock */
        $fileServiceMock = $this->getMockBuilder(FileService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['storeFile'])
            ->getMock();

        $fileServiceMock->expects(self::once())
            ->method('storeFile')
            ->with($this->stringContains(BucketEnum::RESTAURANT), $this->equalTo($fileTmpName));

        $restaurant = new Restaurants();
        $restaurant->restaurantName = 'foo';
        $restaurant->tel_number = '888-456-456';
        $restaurant->categoryId = 1;

        $uploadFile = new UploadedFile([
            'name' => basename($fileTmpName),
            'tempName' => $fileTmpName,
            'type' => 'image/jpg',
            'size' => mt_rand(1000, 10000),
            'error' => '0',
        ]);

        $action = new UploadRestaurantLogo($fileServiceMock);
        $action->run($restaurant, $uploadFile);

        $this->assertFalse($restaurant->hasErrors());
        $this->assertNotEquals(null, $restaurant->img_url);
    }

    public function testDeletePreviousImage(): void
    {
        $fileTmpName = __DIR__ . '/../../../_data/file.png';
        $oldImageUrl = 'oldimage.jpg';

        $restaurant = new Restaurants();
        $restaurant->restaurantName = 'foo';
        $restaurant->tel_number = '888-456-456';
        $restaurant->categoryId = 1;
        $restaurant->img_url = $oldImageUrl;

        /** @var FileService $fileServiceMock */
        $fileServiceMock = $this->getMockBuilder(FileService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['storeFile', 'deleteFile'])
            ->getMock();

        $fileServiceMock->expects(self::once())
            ->method('storeFile')
            ->with($this->stringContains(BucketEnum::RESTAURANT), $this->equalTo($fileTmpName));

        $fileServiceMock->expects(self::once())
            ->method('deleteFile')
            ->with($this->stringContains($restaurant->img_url));

        $uploadFile = new UploadedFile([
            'name' => basename($fileTmpName),
            'tempName' => $fileTmpName,
            'type' => 'image/jpg',
            'size' => mt_rand(1000, 10000),
            'error' => '0',
        ]);

        $action = new UploadRestaurantLogo($fileServiceMock);
        $action->run($restaurant, $uploadFile);

        $this->assertFalse($restaurant->hasErrors());
        $this->assertNotEquals($oldImageUrl, $restaurant->img_url);
    }
}
