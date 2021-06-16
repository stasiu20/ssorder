<?php

namespace App\Tests\Api\Transformer;

use App\Api\Transformer\RestaurantCategoryTransformer;
use App\Restaurant\Entity\Category;
use App\Tests\ObjectMother\RestaurantCategoryObjectMother;
use PHPUnit\Framework\TestCase;

class RestaurantCategoryTransformerTest extends TestCase
{
    /**
     * @dataProvider restaurantsProvider
     *
     * @param Category $category
     */
    public function testTransform(Category $category): void
    {
        $obj = new RestaurantCategoryTransformer();
        $array = $obj->transform($category);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);

        $this->assertEquals($category->getId(), $array['id']);
        $this->assertEquals($category->getName(), $array['name']);
    }

    public function restaurantsProvider(): array
    {
        $restaurant = RestaurantCategoryObjectMother::create(
            [
                'id' => 1,
                'name' => 'foo',
            ]
        );

        return [[$restaurant]];
    }
}
