<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use frontend\models\Imagesmenu;

//var_dump($menu);die;
$this->title = $restaurant->restaurantName;
$this->params['breadcrumbs'][] = $this->title;
$userName = Yii::$app->user->identity->username;
$formatter = \Yii::$app->formatter;
?>
<div class="body-content">
    <div class="row">
        <div class="col-lg-3">  
            <h1><?= Html::encode("{$restaurant->restaurantName}"); ?></h1>
            <p>
                <?=
                Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['restaurants/update', 'id' => $restaurant->id], [
                    'title' => 'Edytuj restaurację',
                ]);
                ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['restaurants/delete', 'id' => $restaurant->id], ['data-method' => 'post', 'data-confirm' => 'Ar ju siur ju wan tu dileit restauracje i oll pozycje w menue?!?', 'title'=>'Usuń restaurację']) ?>
            </p>
            <div class ="img-restaurant"><img  src="/image/<?= $restaurant->img_url ?>" class="img-responsive img-thumbnail"></div>    
            <h5>Numer telefonu:</h5>
            <h3 class="restaurant-summary"><?= Html::encode("{$restaurant->tel_number}"); ?></h3>
            <h5>Koszt dowozu:</h5>
            <h3 class="restaurant-summary"><?= Html::encode("{$restaurant->delivery_price}"); ?> zł</h3>
            <h5>Koszt opakowania:</h5>
            <h3 class="restaurant-summary"><?= Html::encode("{$restaurant->pack_price}"); ?> zł </h3>
            <div class="menuImg">
                <h4>
                    <?php
                    if ($userName == 'Michał') {
                        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => ["site/addimages?id= $restaurant->id"]])
                        ?>
                        <?=
                        $form->field($model, 'imagesMenu_url')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*'],
                            'language' => 'pl',
                        ]);
                        ?>
                        <?php
                        ActiveForm::end();
                    }
                    ?>
                </h4>
                <?php if ($imagesMenu) { echo "<h3>Galeria</h3>"; } ?>
                <?php foreach ($imagesMenu as $imageMenu): ?>
                    <div class="responsive">

                        <div class="img">
                            <?php if ($userName == 'Michał') { ?>           
                                <a class="delete" href="image?id=<?= $restaurant->id ?>&url=<?= $imageMenu->imagesMenu_url; ?>" >
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </a>
                            <?php } ?>
                            <a href="/imagesMenu/<?= $imageMenu->imagesMenu_url; ?>" data-lightbox="<?= $imageMenu->imagesMenu_url; ?>"  data-title="My caption">
                                <img class="menuImage" src="/imagesMenu/<?= $imageMenu->imagesMenu_url; ?>"/>   
                            </a>      
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="info" style="float:left">

                <h3>Menu</h3>
                <p>
                    <?= Html::a('Dodaj pozycję w Menu', ['create', 'id' => $restaurant->id], ['class' => 'btn btn-custom']); ?>
                </p>
            </div>

            <?php if (!empty($menu)) : ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'tableOptions' => ['class' => 'table  table-bordered table-hover'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'foodName',
                        'foodInfo',
                        ['attribute' => 'foodPrice',
                            'format' => 'raw',
                            'value' => function($data) {
                                return "$data->foodPrice" . " " . "zł";
                            },
                            'contentOptions' => ['class' => 'text-right'],
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{order}  {view}  {update} {delete}',
                            'buttons' => [
                                'order' => function($url, $restaurant) {
                                    return Html::a('<span class="glyphicon glyphicon-cutlery"></span>', ['order/uwagi', 'id' => $restaurant->id], [
                                                'title' => 'zamów',
                                    ]);
                                },
                            ],
                            'contentOptions' => ['class' => 'text-center',
                            ],
                        ],
                    ],
                ]);
                ?>
            <?php else: ?>
                <p class="nodata"><?php echo 'Ta restauracja nie ma jeszcze menu'; ?></p>

            <?php endif;
            ?>
        </div>

    </div>
</div>

<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'maxWidth': 20
    })

</script>

