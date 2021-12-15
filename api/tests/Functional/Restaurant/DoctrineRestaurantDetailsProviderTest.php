<?php

namespace App\Tests\Functional\Restaurant;

use App\Contract\Restaurant\Exception\RestaurantNotFoundExceptionInterface;
use App\Restaurant\Provider\DoctrineRestaurantDetailsProvider;
use App\Tests\Story\RestaurantDetailsStory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class DoctrineRestaurantDetailsProviderTest extends KernelTestCase
{
    use Factories;

    /**
     * @var DoctrineRestaurantDetailsProvider
     */
    private $sut;

    /**
     * @var RestaurantDetailsStory|\Zenstruck\Foundry\Story
     */
    private $story;

    protected function setUp(): void
    {
        parent::setUp();

        $this->story = RestaurantDetailsStory::load();

        self::bootKernel();
        /** @var DoctrineRestaurantDetailsProvider $sut */
        $sut = self::getContainer()->get(DoctrineRestaurantDetailsProvider::class);
        $this->sut = $sut;
    }

    /**
     * @group database
     */
    public function testGetDetails(): void
    {
        $dto = $this->sut->getDetails($this->story->getRestaurant()->getId());

        $this->assertNotNull($dto->getId());
        $this->assertNotNull($dto->getName());
        $this->assertNotNull($dto->getDeliveryPrice());
        $this->assertNotNull($dto->getPackPrice());
        $this->assertNotNull($dto->getLogoUrl());
        $this->assertCount(5, $dto->getMenu());

        $this->assertNotNull($dto->getMenu()[0]->getId());
        $this->assertNotNull($dto->getMenu()[0]->getName());
        $this->assertNotNull($dto->getMenu()[0]->getDescription());
        $this->assertNotNull($dto->getMenu()[0]->getPrice());
    }

    /**
     * @group database
     */
    public function testThrowExceptionWhenRestaurantNotFound(): void
    {
        $this->expectException(RestaurantNotFoundExceptionInterface::class);
        $this->sut->getDetails(0);
    }
}
