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
                    <ul id="sidebar">
                        <?php
                        echo '<li>Kategorie:</li>';
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
            <div class="col-lg-8">
                <?php foreach ($restaurants as $restaurant): ?>
                    <div class='restaurant'>
                        <div class="restaurantImg" style="float:left">
                            <a href="/site/restaurant?id=<?= Html::encode("{$restaurant->id}"); ?>"><p> <img src="/image/<?= $restaurant->img_url ?>"></p></a>
                        </div>
                        <div class="content" style="float:left">
                            <h3><a href="/site/restaurant?id=<?= Html::encode("{$restaurant->id}"); ?>"><?= Html::encode("{$restaurant->restaurantName}"); ?></a></h3>
                            <p><a href="?id=<?= $restaurant->category->id ?>"><?= Html::encode("{$restaurant->category->categoryName}"); ?></a></p>
                        </div> 
                        <div class="info" style="float:left">
                            <h6><b>Info</b></h6>
                            <p>nr tel.:<?= Html::encode("{$restaurant->tel_number}"); ?><br/>
                                cena za dowóz: <?= Html::encode("{$restaurant->delivery_price}"); ?> zł<br/>
                                cena za opakowanie: <?= Html::encode("{$restaurant->pack_price}"); ?> zł </p>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                <?php endforeach; ?> 
            </div>
            <div class="col-lg-4">         
            </div>
        </div>
        <footer class="container-fluid text-center"><?= LinkPager::widget(['pagination' => $pagination]) ?></footer>
    </div> 
</div>
