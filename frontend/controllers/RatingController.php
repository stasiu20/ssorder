<?php

namespace frontend\controllers;

use common\models\FoodRating;
use common\models\Order;
use common\services\actions\CreateFoodRating;
use mmo\yii2\filters\SignedUrl;
use mmo\yii2\helpers\UrlHelper;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

class RatingController extends Controller
{
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['token', 'thank-you'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'signedUrl' => [
                'class' => SignedUrl::class,
                'key' => getenv('YII_COOKIE_VALIDATION_KEY'),
                'absolute' => true,
                'only' => ['token']
            ]
        ];
    }

    public function actionOrder(int $orderId)
    {
        $order = $this->getOrder($orderId);
        if ($order->userId !== \Yii::$app->user->identity->getId()) {
            throw new ForbiddenHttpException();
        }

        return $this->rating($order, \Yii::$app->user->identity, UrlHelper::toRoute(['/history/my']));
    }

    public function actionToken(int $order)
    {
        $model = $this->getOrder($order);
        $this->layout = 'mobile.php';
        return $this->rating($model, $model->user, UrlHelper::toRoute(['/rating/thank-you']));
    }

    public function actionThankYou()
    {
        $this->layout = 'mobile.php';
        return $this->render('thank-you');
    }

    /**
     * @param int $orderId
     * @return Order
     * @throws NotFoundHttpException
     */
    private function getOrder(int $orderId): Order
    {
        $order = Order::findOne($orderId);
        if (!$order) {
            throw new NotFoundHttpException();
        }
        if ($order->rating) {
            throw new NotFoundHttpException('Order has rating');
        }
        return $order;
    }

    /**
     * @param Order $order
     * @param IdentityInterface $identity
     * @param $url
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    private function rating(Order $order, IdentityInterface $identity, $url)
    {
        $rating = new FoodRating();
        if (\Yii::$app->request->isPost) {
            $rating->load(\Yii::$app->request->post());
            $rating->order_id = $order->id;
            if ($rating->validate(['review', 'rating', 'order_id'])) {
                /** @var CreateFoodRating $service */
                $service = \Yii::$container->get(CreateFoodRating::class);
                $service->run($identity, $order, $rating->rating, $rating->review);
                return $this->redirect($url);
            }
        }

        return $this->render('order', [
            'model' => $rating,
        ]);
    }
}
