<?php

namespace frontend\controllers;

use common\enums\BucketEnum;
use common\helpers\ArrayHelper;
use common\iterators\ChunkedIterator;
use common\models\History;
use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use common\services\FileService;
use frontend\helpers\FileServiceViewHelper;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Restaurants;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\models\Menu;
use yii\data\ActiveDataProvider;
use frontend\models\MenuSearch;
use yii\data\Pagination;
use frontend\models\Category;
use frontend\models\Imagesmenu;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @param int $id
     * @return mixed
     */
    public function actionIndex($id = 0)
    {

        if ($id > 0) {           //tu trzeba dać && nie więcej niż ostatni rekord w bazie
            $query = Restaurants::findActiveRestaurants()->andWhere(['categoryId' => $id]);
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count(),]);
            $restaurants = $query->orderBy('restaurantName')
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
            //$restaurants = $category->restaurants;
        } else {
            $query = Restaurants::findActiveRestaurants();
            $pagination = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $query->count(),]);
            $restaurants = $query->orderBy('restaurantName')
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
        }

        $categorys = Category::findActive()->all();
        return $this->render('index', [
                    'restaurants' => $restaurants,
                    'categorys' => $categorys,
                    'pagination' => $pagination,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Sprawdz swojego maila i kliknij link do zmiany hasła.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Niestety nie możemy zmienić ci hasła.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Hasło zostało zmienione poprawnie.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    /**
     * @param $id int
     * @return string
     */
    public function actionCategory($id): string
    {
        $categorys = \frontend\models\Category::findOne($id);

        return $this->render('category', ['categorys' => $categorys]);
    }

    /**
     * @param $id int
     * @return string
     */
    public function actionRestaurant($id)
    {
        $restaurant = Restaurants::findOne($id);
        $imagesMenu = Imagesmenu::find()->where(['restaurantId' => $id])->all();
        $menu = $restaurant->menu;
        $restaurants = Restaurants::find()->all();
        $model = new Imagesmenu();
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find()->where(['restaurantId' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        return $this->render('restaurant', ['restaurant' => $restaurant,
                    'menu' => $menu,
                    'dataProvider' => $dataProvider,
                    'restaurants' => $restaurants,
                    'model' => $model,
                    'imagesMenu' => $imagesMenu,
        ]);
    }

    /**
     * @param $id int
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var Menu $menu */
        $menu = Menu::findOne($id);
        $restaurant = $menu->restaurant;

        $filters = new OrderFilters();
        $filters->status = Order::STATUS_REALIZED;
        $filters->foodId = $id;
        $lastOrdersProvider = new ActiveDataProvider([
            'query' => OrderSearch::search($filters),
            'pagination' => new Pagination(),
            'sort' => History::getDefaultSort()
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'restaurant' => $restaurant,
            'lastOrdersProvider' => $lastOrdersProvider
        ]);
    }

    /**
     * @param $id int
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

    /**
     * @param $id int
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $menu = $model;
            $restaurant = $menu->restaurant;
            return $this->render('updateMenu', [
                        'model' => $model,
                        'restaurant' => $restaurant,
            ]);
        }
    }

    /**
     * @param $id int
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new Menu();
        $restaurant = Restaurants::findOne($id);
        $model->restaurantId = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['restaurant', 'id' => $restaurant->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'restaurant' => $restaurant,
            ]);
        }
    }

    /**
     * @param $id int
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $menu = $this->findModel($id);
        $restaurant = $menu->restaurant;
        $menu->softDelete();

        return $this->redirect(['restaurant', 'id' => $restaurant->id]);
    }

    /**
     * @param $url string
     * @param $id int
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionImage($url, $id)
    {
        $img = Imagesmenu::findOne(['imagesMenu_url' => $url]);
        $restaurantId = Yii::$app->request->get('id');

        if ($img && Yii::$app->request->isGet) {
            /** @var FileService $fileService */
            $fileService = Yii::$container->get(FileService::class);
            $fileService->deleteFile(FileServiceViewHelper::getMenuImageKey($img->imagesMenu_url));
            $img->softDelete();
            return $this->redirect("restaurant?id=$restaurantId");
        }
    }
}
