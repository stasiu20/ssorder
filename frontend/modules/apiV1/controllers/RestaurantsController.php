<?php

namespace frontend\modules\apiV1\controllers;

use common\services\SymfonyApiClient;
use frontend\models\Restaurants;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use \OpenApi\Annotations as OA;

class RestaurantsController extends Controller
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbFilter']['actions'] = [
            'index' => ['get'],
            'details' => ['get'],
        ];
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                ['actions' => ['index', 'foods', 'details'], 'allow' => true, 'roles' => ['@']],
            ]
        ];
        return $parent;
    }

    /**
     * @OA\Get(
     *      path="/restaurants",
     *      operationId="getRestaurantsList",
     *      tags={"Restaurants"},
     *      summary="Get list of restaurants",
     *      description="Returns list of restaurants",
     *      security={{"jwtToken": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Restaurant"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionIndex(): array
    {
        /** @var SymfonyApiClient $symfonyApiClient */
        $symfonyApiClient = Yii::$container->get(SymfonyApiClient::class);

        return $symfonyApiClient->getRestaurants();
    }

    /**
     * @OA\Get(
     *     path="/restaurants/{restaurantId}/foods",
     *     operationId="getRestaurantFoodsList",
     *     tags={"Restaurants"},
     *     summary="Get list of foods in restaurant",
     *     description="Returns list of foods in restaurant",
     *     security={{"jwtToken": {}}},
     *     @OA\Parameter(
     *         name="restaurantId",
     *         description="Restaurant id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Food"),
     *         )
     *      ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     * @param int $restaurantId
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionFoods(int $restaurantId)
    {
        $restaurant = Restaurants::findOne($restaurantId);
        if (null === $restaurant) {
            throw new NotFoundHttpException('Restaurant not exists');
        }

        /** @var SymfonyApiClient $symfonyApiClient */
        $symfonyApiClient = Yii::$container->get(SymfonyApiClient::class);
        $menu =  $symfonyApiClient->getMenu($restaurantId);

        Yii::$app->response->headers->add('X-Pagination-Current-Page', 1);
        Yii::$app->response->headers->add('X-Pagination-Page-Count', count($menu));
        Yii::$app->response->headers->add('X-Pagination-Per-Page', count($menu));
        Yii::$app->response->headers->add('X-Pagination-Total-Count', count($menu));

        return $menu;
    }

    /**
     * @OA\Get(
     *      path="/restaurants/{restaurantId}/details",
     *      operationId="getRestaurantDetails",
     *      tags={"Restaurants"},
     *      summary="Get details of restaurant",
     *      description="Get details of restaurant",
     *      security={{"jwtToken": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/RestaurantDetails"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function actionDetails(int $restaurantId)
    {
        $restaurant = Restaurants::findOne($restaurantId);
        if (null === $restaurant) {
            throw new NotFoundHttpException('Restaurant not exists');
        }

        /** @var SymfonyApiClient $symfonyApiClient */
        $symfonyApiClient = Yii::$container->get(SymfonyApiClient::class);

        return $symfonyApiClient->getRestaurantDetails($restaurantId);
    }
}
