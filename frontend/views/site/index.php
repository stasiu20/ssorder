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
                <div id = "sidebarDiv">
                    <h3>Kategorie:</h3>
                    <ul id="sidebar">
                        <?php
                        foreach ($categorys as $category) {
                            ?>
                            <li><a href = "?id=<?= $category->id ?>"><?= $category->categoryName ?></a></li>
                            <?php
                        }
                        ?>
                        <li><a href = "?id=0">Wszystko</a></li>
                    </ul> 
                </div>               
            </div>
            <div class="col-lg-10">
                <?php foreach ($restaurants as $restaurant): ?>
                    <div class='restaurant'>
                        <div class="restaurant-image" style="background-image: url(/image/<?= $restaurant->img_url ?>)">
    <!--                            <a href="/site/restaurant?id=<?= Html::encode("{$restaurant->id}"); ?>"><p> <img src="/image/<?= $restaurant->img_url ?>"></p></a>-->
                        </div>
                        <div class="restaurant-content">
                            <div class="content">
                                <p class="restaurant-name"><a href="/site/restaurant?id=<?= Html::encode("{$restaurant->id}"); ?>"><?= Html::encode("{$restaurant->restaurantName}"); ?></a></h3>
                                <p><a href="?id=<?= $restaurant->category->id ?>"><?= Html::encode("{$restaurant->category->categoryName}"); ?></a></p>
                            </div> 
                            <div class="info">
                                <h4><img src="/image/phone.png" class="restaurant-details-icon" /> <?= Html::encode("{$restaurant->tel_number}"); ?></h4>
                                <p class="restaurant-details"><img src="/image/car.png" class="restaurant-details-icon" /> <?= Html::encode("{$restaurant->delivery_price}"); ?> zł</p>
                                <p class="restaurant-details"><img src="/image/box.png" class="restaurant-details-icon" /> <?= Html::encode("{$restaurant->pack_price}"); ?> zł </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?> 
            </div>
<!--            <div class="col-lg-4">         
            </div>-->
        </div>
        <footer class="container-fluid text-center"><?= LinkPager::widget(['pagination' => $pagination]) ?></footer>
    </div> 
</div>
