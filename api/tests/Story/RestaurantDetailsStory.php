<?php

namespace App\Tests\Story;

use App\Restaurant\Entity\Restaurant;
use App\Tests\Factory\MenuPositionFactory;
use App\Tests\Factory\RestaurantFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Story;

final class RestaurantDetailsStory extends Story
{
    public const RESTAURANT = 'restaurant';

    public function build(): void
    {
        $restaurant = RestaurantFactory::createOne();
        MenuPositionFactory::createMany(5, ['restaurant' => $restaurant]);

        $this->addState(self::RESTAURANT, $restaurant);
    }

    /**
     * @return Proxy<Restaurant>&Restaurant
     */
    public function getRestaurant(): object
    {
        return $this->get(self::RESTAURANT);
    }
}
