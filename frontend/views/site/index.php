<?php
/* @var $this yii\web\View */

use frontend\helpers\FileServiceViewHelper;
use yii\helpers\Html;
use frontend\models\Category;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Order you posiłek';
$this->params['breadcrumbs'][] = $this->title;
//var_dump($identity = Yii::$app->user->identity->username);die;
?>
<div class="site-index">
    <div class="jumbotron">
        <h2>To co dziś zamawiamy?!</h2>
    </div>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-2">
                <div id="sidebarDiv">
                    <h3>Kategorie:</h3>
                    <ul id="sidebar">
                        <?php
                        foreach ($categorys as $category) {
                            ?>
                            <li><a href="?id=<?= $category->id ?>"><?= $category->categoryName ?></a></li>
                            <?php
                        }
                        ?>
                        <li><a href="?id=0">Wszystko</a></li>
                    </ul>
                </div>
            </div>
            <div id="restaurants-card-container" class="col-lg-10 bs4" style="background-color: #F5F3EE">
                <?php foreach ($restaurants as $restaurant): ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                    <?php if ($restaurant instanceof \frontend\models\Restaurants): ?>
                                        <div class="app-card mb-4">
                                            <div class="app-card__side app-card__side--front">
                                                <div class="app-card__header">
                                                    <img class="app-card__img" src="<?= FileServiceViewHelper::getRestaurantImageUrl($restaurant->img_url) ?>" alt="<?= $restaurant->restaurantName ?>" />
                                                    <h4 class="app-card__title"><span><?= $restaurant->restaurantName ?></span></h4>
                                                </div>
                                                <div class="app-card__details">
                                                    <ul>
                                                        <li>
                                                            <div class="d-inline-flex align-items-center">
                                                                <span class="material-icons d-inline-block mr-2">restaurant</span>
                                                                <span><?= $restaurant->category->categoryName ?></span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="d-inline-flex align-items-center">
                                                                <span class="material-icons d-inline-block mr-2">phone</span>
                                                                <span><?= $restaurant->tel_number ?></span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="d-inline-flex align-items-center">
                                                                <span class="material-icons d-inline-block mr-2">local_shipping</span>
                                                                <span><?= $restaurant->delivery_price ?></span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="d-inline-flex align-items-center">
                                                                <span class="material-icons d-inline-block mr-2">shopping_basket</span>
                                                                <span><?= $restaurant->pack_price ?></span>
                                                            </div>
                                                        </li>
                                                </div>
                                            </div>
                                            <div class="app-card__side app-card__side--back text-center">
                                                <div class="app-card__side-container">
                                                    <h4 class="mb-small"><?= $restaurant->restaurantName ?></h4>
                                                    <a class="btn btn-light btn-lg" href="<?= Url::to(['/site/restaurant', 'id' => $restaurant->id]) ?>"><?= Yii::t('app', 'Order') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                        </div>
                <?php endforeach; ?>
            </div>
            <footer class="container-fluid text-center"><?= LinkPager::widget(['pagination' => $pagination]) ?></footer>
        </div>
    </div>
