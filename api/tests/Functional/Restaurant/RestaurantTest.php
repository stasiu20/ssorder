<?php

namespace App\Tests\Functional\Restaurant;

use App\Tests\Factory\PhotoFactory;
use App\Tests\Story\RestaurantPhotosStory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class RestaurantTest extends KernelTestCase
{
    use Factories;

    /**
     * @group database
     */
    public function testGetPhotosIgnoreDeleted(): void
    {
        // todo mmo remove this after migrate fixtures to symfony
        PhotoFactory::repository()->truncate();

        $story = RestaurantPhotosStory::load();
        $this->assertCount(1, $story->getRestaurant()->getPhotos());
        PhotoFactory::repository()->assert()->count(4);
    }
}
