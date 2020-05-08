<?php

namespace frontend\controllers;

use common\enums\OrderSource;
use common\events\BeforeRealizedOrdersEvent;
use common\events\Orders;
use common\events\RealizedOrdersEvent;
use common\models\History;
use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use common\repositories\OrderRepository;
use frontend\helpers\OrderCost;
use frontend\models\Imagesmenu;
use frontend\models\Menu;
use frontend\models\Restaurants;
use frontend\services\OrderSummaryStatics;
use Tightenco\Collect\Support\Collection;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\validators\DateValidator;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{

    public function behaviors()
    {

        return [
                'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index', 'upload', 'restaurant', 'delete', 'update', 'category', 'restaurant', 'view', 'create'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'upload', 'restaurant', 'update', 'delete', 'category', 'restaurant', 'view', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                ],
        ];
    }

    public function actionIndex($date = null)
    {
        $dateValue = $date ? $date : date('Y-m-d');
        $validator = new DateValidator(['format' => 'php:Y-m-d']);
        if (!$validator->validate($dateValue)) {
            throw new BadRequestHttpException('Wrong date format');
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $dateValue);
        $tomorrow = $date->add(new \DateInterval('P1D'));
        $yesterday = $date->sub(new \DateInterval('P1D'));
        $sevenDaysAgo = $date->sub(new \DateInterval('P7D'));
        $sevenDaysFuture = $date->add(new \DateInterval('P7D'));

        $filters = new OrderFilters();
        $filters->dateFrom = $date->format('Y-m-d');
        $filters->dateTo = $tomorrow->format('Y-m-d');

        /** @var OrderRepository $orderRepository */
        $orderRepository = Yii::$container->get(OrderRepository::class);
        [$orders, $summary] = $orderRepository->ordersByRestaurantWithStats($filters);

        return $this->render('index', [
            'orderCollection' => $orders,
            'date' => $date,
            'minDate' => \DateTime::createFromFormat('Y-m-d', '2000-01-01'),
            'today' => new \DateTime('now'),
            'tomorrow' => $tomorrow,
            'yesterday' => $yesterday,
            'sevenDaysAgo' => $sevenDaysAgo,
            'sevenDaysNext' => $sevenDaysFuture,
            'summary' => $summary,
        ]);
    }

    public function actionUwagi($id)
    {

        $model = $this->findModel($id);
        $order = new Order();

        if (Yii::$app->request->isPost) {
            $order->load(Yii::$app->request->post());
            $order->uwagi = strip_tags($order->uwagi);

            $order->userId = Yii::$app->user->identity->id;
            $order->foodId = $model->id;
            $order->restaurantId = $model->restaurantId;
            $order->status = Order::STATUS_NOT_REALIZED;

            /** @var \common\component\Order $orderComponent */
            $orderComponent = Yii::$app->order;
            if ($orderComponent->addOrder($order, OrderSource::WEB)) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('uwagi', [
                    'model' => $model,
                    'order' => $order
        ]);
    }

    public function actionAgain($id)
    {
        $order = Order::findOne($id);
        if (null === $order) {
            throw new NotFoundHttpException('Order not exist');
        }

        $order = $order->cloneOrder();

        return $this->render('again', [
            'order' => $order
        ]);
    }

    /**
     * @param $id
     * @return Menu
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Menu
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelete()
    {
        if (null !== Yii::$app->request->post('id')) {
            $id= Yii::$app->request->post('id');
            $model = Order::findOne($id);
            $model->softDelete();
            return $this->redirect(['index']);
        }
    }

    public function actionEdit()
    {

        if (Yii::$app->request->isPost && Yii::$app->request->post('name')==Yii::$app->user->identity->username) {
            $id= Yii::$app->request->post('id');
            $order = Order::findOne($id);
            $model = Menu::findOne($order->foodId);

            return $this->render('uwagi', [
                    'model' => $model,
                    'order' => $order
            ]);
        } else if (null !== Yii::$app->request->post('Order')) {
            $id= Yii::$app->request->post('Order')['orderId'];
            $order = Order::findOne($id);
            $order->load(Yii::$app->request->post());
            $orderUwagi = strip_tags($order->uwagi);
            $order->uwagi = $orderUwagi;
            $order->update();
            //$order->save();
            if ($order->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionRestaurant($id)
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));
        $tomorrow = $date->add(new \DateInterval('P1D'));

        $restaurant = Restaurants::findOne($id);
        $imagesMenu = Imagesmenu::find()->where(['restaurantId' => $id])->all();
        $filters = new OrderFilters();
        $filters->restaurantId = $id;
        $filters->dateFrom = $date->format('Y-m-d');
        $filters->dateTo = $tomorrow->format('Y-m-d');
        $filters->status = Order::STATUS_NOT_REALIZED;

        $dataProvider = new ActiveDataProvider([
            'query' => OrderSearch::search($filters),
            'sort' => History::getDefaultSort(),
            'pagination' => new Pagination()
        ]);

        /** @var \common\component\Order $orderComponent */
        $orderComponent = \Yii::$app->order;
        $orderComponent->trigger(
            BeforeRealizedOrdersEvent::EVENT_BEFORE_REALIZED_ORDERS,
            BeforeRealizedOrdersEvent::factory(
                $dataProvider->getModels(),
                Yii::$app->user->identity
            )
        );

        return $this->render('takeOrder', ['restaurant' => $restaurant,
            'imagesMenu' => $imagesMenu,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOrderCompleted($id)
    {
        $date = date('Y-m-d');

        $filters = new OrderFilters();
        $filters->restaurantId = $id;
        $filters->dateFrom = $date;

        /** @var Order[] $orders */
        $orders = OrderSearch::search($filters)->all();
        $count = count($orders);
        for ($i = 0; $i < $count; $i++) {
            $order = $orders[$i];
            $order->price = $order->getPrice();
            $order->status = Order::STATUS_REALIZED;
            if (null === $order->realizedBy) {
                $order->realizedBy = Yii::$app->user->identity->id;
            }
            $order->total_price = OrderCost::calculateOrderCost($order, $count, $i);
            $order->save();
        }

        /** @var \common\component\Order $orderComponent */
        $orderComponent = \Yii::$app->order;
        $orderComponent->trigger(
            RealizedOrdersEvent::EVENT_REALIZED_ORDERS,
            RealizedOrdersEvent::factoryFromArrayOrders($orders)
        );

        return $this->redirect('index');
    }
}
