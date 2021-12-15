<?php

namespace common\tests\unit\fixtures;

use common\enums\BucketEnum;
use common\services\FileService;
use common\services\FixtureStore;
use Faker\Factory;
use frontend\models\Imagesmenu;
use frontend\models\Restaurants;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;
use yii\test\ActiveFixture;

class RestaurantFixture extends ActiveFixture
{
    public $modelClass = Restaurants::class;
    public $depends = [CategoryFixture::class];

    public function beforeLoad(): void
    {
        parent::beforeLoad();
        FixtureStore::getInstance()->addFixture($this);
    }

    public function afterLoad(): void
    {
        Imagesmenu::deleteAll();
        $faker = Factory::create();
        $faker->addProvider(new PicsumProvider($faker));
        $faker->addProvider(new LoremSpaceProvider($faker));

        /** @var Restaurants $restaurant */
        foreach (array_keys($this->data) as $alias) {
            $restaurant = $this->getModel($alias);
            $path = $faker->picsum(null, 400, 400, true);

            $key = basename($path);
            $restaurant->img_url = $key;
            /** @var FileService $fileService */
            $fileService = \Yii::$container->get(FileService::class);
            $fileService->storeFile(BucketEnum::RESTAURANT . '/' . $key, $path);
            $restaurant->save(false);

            $max = random_int(0, 3);
            for ($i = 0; $i < $max; $i++) {
                $category = [
                    LoremSpaceProvider::CATEGORY_FURNITURE,
                    LoremSpaceProvider::CATEGORY_ALBUM,
                    LoremSpaceProvider::CATEGORY_MOVIE
                ];
                $path = $faker->loremSpace($category[array_rand($category)], null, 400, 400, true);
                $key = basename($path);

                $photo = new Imagesmenu();
                $photo->restaurantId = $restaurant->id;
                $photo->imagesMenu_url = $key;
                $fileService->storeFile(BucketEnum::MENU . '/' . $key, $path);
                $photo->save(true);
            }
        }
    }
}
