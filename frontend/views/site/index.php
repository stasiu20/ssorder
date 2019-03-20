<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\models\Category;
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
                <?php foreach ($restaurants as $chunk): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-deck">
                                <?php foreach ($chunk as $restaurant): ?>
                                    <?php if ($restaurant instanceof \frontend\models\Restaurants): ?>
                                        <div class="card">
                                            <a href="/site/restaurant?id=<?= Html::encode("{$restaurant->id}"); ?>">
                                                <img class="card-img-top" src="/image/<?= $restaurant->img_url ?>"
                                                     alt="<?= $restaurant->restaurantName; ?>"/>
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="/site/restaurant?id=<?= Html::encode("{$restaurant->id}"); ?>">
                                                        <?= Html::encode("{$restaurant->restaurantName}"); ?>
                                                    </a>
                                                </h5>
                                                <p class="card-text">
                                                    <a href="?id=<?= $restaurant->category->id ?>"><?= Html::encode("{$restaurant->category->categoryName}"); ?></a>
                                                </p>
                                                <p class="restaurant-details">
                                                    <i class="fas fa-phone"></i>
                                                    <?= Html::encode("{$restaurant->tel_number}"); ?>
                                                <p class="restaurant-details">
                                                    <i class="fas fa-car-side"></i>
                                                    <?= Html::encode("{$restaurant->delivery_price}"); ?> zł
                                                </p>
                                                <p class="restaurant-details">
                                                    <i class="fas fa-box"></i>
                                                    <?= Html::encode("{$restaurant->pack_price}"); ?> zł
                                                </p>
                                                </p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="card invisible"></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <footer class="container-fluid text-center"><?= LinkPager::widget(['pagination' => $pagination]) ?></footer>
        </div>
    </div>
