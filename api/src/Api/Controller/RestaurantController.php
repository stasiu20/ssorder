<?php

namespace App\Api\Controller;

use App\Api\Resource\RestaurantResource;
use App\Restaurant\Repository\RestaurantRepository;
use League\Fractal\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/api/v1/restaurants", methods={"GET"}, name="api.restaurants")
     *
     * @param RestaurantResource   $restaurantResource
     * @param RestaurantRepository $restaurantRepository
     * @param Manager              $manager
     *
     * @return JsonResponse
     */
    public function list(
        RestaurantResource $restaurantResource,
        RestaurantRepository $restaurantRepository,
        Manager $manager
    ): JsonResponse {
        $restaurants = $restaurantRepository->findActiveRestaurants();
        $collection = $restaurantResource->factoryCollection($restaurants);

        return new JsonResponse($manager->createData($collection)->toArray());
    }
}
