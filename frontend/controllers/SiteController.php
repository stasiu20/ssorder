<?php

namespace frontend\controllers;

use common\models\LoginForm;
use frontend\models\Category;
use frontend\models\Imagesmenu;
use frontend\models\Menu;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\Restaurants;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

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
                'only' => ['logout', 'signup', 'index', 'upload', 'restaurant', 'category', 'restaurant'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'upload', 'restaurant', 'category', 'restaurant'],
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
    public function actionRestaurant($id)
    {
        $restaurant = Restaurants::findOne($id);
        $imagesMenu = Imagesmenu::find()->where(['restaurantId' => $id, 'deletedAt' => null])->all();
        $menu = $restaurant->menu;
        $restaurants = Restaurants::find()->all();
        $model = new Imagesmenu();
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find()->where(['restaurantId' => $id])->andWhere(['deletedAt' => null]),
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
}
