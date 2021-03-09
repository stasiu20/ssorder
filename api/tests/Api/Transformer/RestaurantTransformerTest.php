<?php

namespace App\Tests\Api\Transformer;

use App\Restaurant\Entity\Restaurant;
use App\Tests\ObjectMother\RestaurantObjectMother;
use App\Tests\ObjectMother\RestaurantTransformerObjectMother;
use PHPUnit\Framework\TestCase;

class RestaurantTransformerTest extends TestCase
{
    /**
     * @dataProvider restaurantsProvider
     *
     * @param Restaurant $restaurant
     */
    public function testTransform(Restaurant $restaurant): void
    {
        $obj = RestaurantTransformerObjectMother::createWithPublicUrl('https://cdn.example.com');
        $array = $obj->transform($restaurant);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('category', $array);
        $this->assertArrayHasKey('imageUrl', $array);
        $this->assertArrayHasKey('packPrice', $array);
        $this->assertArrayHasKey('deliveryPrice', $array);
        $this->assertArrayHasKey('telNumber', $array);

        if (empty($restaurant->getImgUrl())) {
            $this->assertNull($array['imageUrl']);
        } else {
            $this->assertStringEndsWith($restaurant->getImgUrl(), $array['imageUrl']);
        }

        $this->assertEquals($restaurant->getId(), $array['id']);
        $this->assertEquals($restaurant->getName(), $array['name']);
        $this->assertEquals($restaurant->getCategoryId(), $array['category']);
        $this->assertEquals($restaurant->getPackPrice(), $array['packPrice']);
        $this->assertEquals($restaurant->getDeliveryPrice(), $array['deliveryPrice']);
        $this->assertEquals($restaurant->getPhoneNumber(), $array['telNumber']);
    }

    public function restaurantsProvider(): array
    {
        $restaurant = RestaurantObjectMother::create(
            [
                'id' => 1,
                'name' => 'foo',
                'categoryId' => 2,
                'pack_price' => 2,
                'delivery_price' => 1,
                'phoneNumber' => '854-852-852',
            ]
        );

        $restaurant2 = RestaurantObjectMother::create(
            [
                'id' => 2,
                'name' => 'bar',
                'categoryId' => 3,
                'pack_price' => 3,
                'delivery_price' => 3,
                'phoneNumber' => '741-852-852',
                'img_url' => 'test.jpg',
            ]
        );

        $restaurant3 = RestaurantObjectMother::create(
            [
                'id' => 3,
                'name' => 'bar',
                'categoryId' => 3,
                'pack_price' => 3,
                'delivery_price' => 2,
                'phoneNumber' => '741-852-963',
                'img_url' => '',
            ]
        );

        return [[$restaurant], [$restaurant2], [$restaurant3]];
    }
}
