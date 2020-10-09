<?php

namespace common\tests\unit\transformers;

use Codeception\Test\Unit;
use common\tests\fake\RestaurantFake;
use common\transformers\RestaurantTransformer;
use frontend\models\Restaurants;

class RestaurantTransformerTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @dataProvider restaurantsProvider
     * @param Restaurants $restaurant
     */
    public function testTransform(Restaurants $restaurant): void
    {
        $obj = new RestaurantTransformer();
        $array = $obj->transform($restaurant);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('category', $array);
        $this->assertArrayHasKey('imageUrl', $array);
        $this->assertArrayHasKey('packPrice', $array);
        $this->assertArrayHasKey('deliveryPrice', $array);
        $this->assertArrayHasKey('telNumber', $array);

        if (empty($restaurant->img_url)) {
            $this->assertNull($array['imageUrl']);
        } else {
            $this->assertStringEndsWith($restaurant->img_url, $array['imageUrl']);
        }
        $this->assertEquals($restaurant->id, $array['id']);
        $this->assertEquals($restaurant->restaurantName, $array['name']);
        $this->assertEquals($restaurant->categoryId, $array['category']);
        $this->assertEquals($restaurant->pack_price, $array['packPrice']);
        $this->assertEquals($restaurant->delivery_price, $array['deliveryPrice']);
        $this->assertEquals($restaurant->tel_number, $array['telNumber']);
    }

    public function restaurantsProvider(): array
    {
        $restaurant = new RestaurantFake();
        $restaurant->id = 1;
        $restaurant->restaurantName = 'foo';
        $restaurant->categoryId = 2;
        $restaurant->pack_price = 2;
        $restaurant->delivery_price = 1;
        $restaurant->tel_number = '854-852-852';

        $restaurant2 = new RestaurantFake();
        $restaurant2->id = 2;
        $restaurant2->restaurantName = 'bar';
        $restaurant2->categoryId = 3;
        $restaurant2->pack_price = 3;
        $restaurant2->delivery_price = 3;
        $restaurant2->tel_number = '741-852-852';
        $restaurant2->img_url = 'test.jpg';

        $restaurant3 = new RestaurantFake();
        $restaurant3->id = 3;
        $restaurant3->restaurantName = 'bar';
        $restaurant3->categoryId = 3;
        $restaurant3->pack_price = 3;
        $restaurant3->delivery_price = 2;
        $restaurant3->tel_number = '741-852-963';
        $restaurant3->img_url = '';

        $restaurant3 = new RestaurantFake();

        return [[$restaurant], [$restaurant2], [$restaurant3]];
    }
}
