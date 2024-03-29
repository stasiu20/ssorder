<?php

namespace App\Api\Controller;

use App\Api\Resource\MenuResource;
use App\Api\Resource\RestaurantResource;
use App\Contract\Restaurant\Exception\RestaurantNotFoundExceptionInterface;
use App\Contract\Restaurant\RestaurantDetailsProviderInterface;
use App\Restaurant\Entity\Restaurant;
use App\Restaurant\Repository\RestaurantRepository;
use League\Fractal\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/api/v1/restaurants/{id}/menu", methods={"GET"}, name="api.restaurant.menu")
     *
     * @param Restaurant   $restaurant
     * @param Manager      $manager
     * @param MenuResource $menuResource
     *
     * @return Response
     */
    public function menu(Restaurant $restaurant, Manager $manager, MenuResource $menuResource): Response
    {
        $collection = $restaurant->getMenu();
        $data = $manager->createData($menuResource->factoryCollection($collection->toArray()))->toArray()['data'];

        $response = new JsonResponse($data);
        $response->headers->set('X-Pagination-Current-Page', (string) 1);
        $response->headers->set('X-Pagination-Page-Count', (string) $collection->count());
        $response->headers->set('X-Pagination-Per-Page', (string) $collection->count());
        $response->headers->set('X-Pagination-Total-Count', (string) $collection->count());

        return $response;
    }

    /**
     * @Route("/api/v1/restaurants/{id}/details", methods={"GET"}, name="api.restaurant.details")
     *
     * @param int                                $id
     * @param RestaurantDetailsProviderInterface $restaurantDetailsProvider
     *
     * @return JsonResponse
     */
    public function details(int $id, RestaurantDetailsProviderInterface $restaurantDetailsProvider): JsonResponse
    {
        try {
            $restaurantDetails = $restaurantDetailsProvider->getDetails($id);

            return $this->json(['data' => $restaurantDetails]);
        } catch (RestaurantNotFoundExceptionInterface $e) {
            throw $this->createNotFoundException();
        }
    }
}
