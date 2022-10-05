<?php

namespace App\Tests\Story;

use App\Restaurant\Entity\Restaurant;
use App\Tests\Factory\PhotoFactory;
use App\Tests\Factory\RestaurantFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Story;

final class RestaurantPhotosStory extends Story
{
    private const RESTAURANT = 'restaurant';

    public function build(): void
    {
        $restaurant = RestaurantFactory::createOne();
        $factoryPhoto = PhotoFactory::new(['restaurant' => $restaurant]);
        $factoryPhoto->create();
        $factoryPhoto->markAsDeleted()->create();
        $restaurant->save();
        $this->addState(self::RESTAURANT, $restaurant);

        $restaurant2 = RestaurantFactory::createOne();
        $factoryPhoto = PhotoFactory::new(['restaurant' => $restaurant2]);
        $factoryPhoto->create();
        $factoryPhoto->markAsDeleted()->create();
        $restaurant2->save();
    }

    /**
     * @return Proxy<Restaurant>&Restaurant
     */
    public function getRestaurant(): object
    {
        return $this->get(self::RESTAURANT);
    }
}
