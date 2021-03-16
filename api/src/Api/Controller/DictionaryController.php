<?php

namespace App\Api\Controller;

use App\Api\Resource\RestaurantCategoryResource;
use App\Restaurant\Repository\CategoryRepository;
use League\Fractal\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DictionaryController extends AbstractController
{
    /**
     * @Route("/api/v1/dictionaries/categories", methods={"GET"}, name="api.dictionary.categories")
     *
     * @param RestaurantCategoryResource $restaurantResource
     * @param CategoryRepository         $categoryRepository
     * @param Manager                    $manager
     *
     * @return JsonResponse
     */
    public function categories(
        RestaurantCategoryResource $restaurantResource,
        CategoryRepository $categoryRepository,
        Manager $manager
    ): JsonResponse {
        $categories = $categoryRepository->findActiveCategories();
        $collection = $restaurantResource->factoryCollection($categories);

        return new JsonResponse($manager->createData($collection)->toArray());
    }
}
