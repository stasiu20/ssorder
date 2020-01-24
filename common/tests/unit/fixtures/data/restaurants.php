<?php

use yii\test\ActiveFixture;

/** @var $this ActiveFixture */
global $fixtures;
/** @var ActiveFixture $fixtureCat */
$fixtureCat = $fixtures[\common\tests\unit\fixtures\CategoryFixture::class];
return [
    'restaurant1' => [
        'restaurantName' => 'Thien Ly - tulibu dibu douchoo',
        'tel_number' => '889-515-323',
        'delivery_price' => 3.0,
        'pack_price' => 0.5,
        'img_url' => '01f115e88514f850c792042c645d06be.jpg',
        'categoryId' => $fixtureCat->getModel('chineseFood')->id
    ],
    'restaurant2' => [
        'restaurantName' => 'BurgeRoom',
        'tel_number' => '618408231',
        'delivery_price' => 1.55,
        'pack_price' => 1.33,
        'img_url' => '455b35bc6a8acbfeef2a488de7cbea84.jpg',
        'categoryId' => $fixtureCat->getModel('burgers')->id
    ],
    'restaurant3' => [
        'restaurantName' => 'Ramzes',
        'tel_number' => '376986345',
        'delivery_price' => 1,
        'pack_price' => 1,
        'img_url' => '7fa6a0f772be316f129bd8c30b964f80.jpg',
        'categoryId' => $fixtureCat->getModel('kebab')->id
    ],
    'restaurant4' => [
        'restaurantName' => 'Gruby Benek',
        'tel_number' => '912516706',
        'delivery_price' => 2,
        'pack_price' => 0.5,
        'img_url' => '913f05c0950388bb2c0942ba7a3d148e.jpg',
        'categoryId' => $fixtureCat->getModel('pizza')->id
    ],
    'restaurant5' => [
        'restaurantName' => 'Palmyra',
        'tel_number' => '348782701',
        'delivery_price' => 0,
        'pack_price' => 1,
        'img_url' => '30122622a0f9663001dcfe4a317264fe.jpg',
        'categoryId' => $fixtureCat->getModel('kebab')->id
    ],
    'restaurant6' => [
        'restaurantName' => 'Kebab King Star',
        'tel_number' => '131989707',
        'delivery_price' => 5.5,
        'pack_price' => 0,
        'img_url' => '9cf9634c2d26d41e677e09027041f0bc.jpg',
        'categoryId' => $fixtureCat->getModel('kebab')->id
    ],
    'restaurant7' => [
        'restaurantName' => 'Jadłodajnia do Syta',
        'tel_number' => '540689426',
        'delivery_price' => 0,
        'pack_price' => 1.5,
        'img_url' => '40a59daed3e83dbec1f2973468885558.jpg',
        'categoryId' => $fixtureCat->getModel('polak')->id
    ],
    'restaurant8' => [
        'restaurantName' => 'Sajgon',
        'tel_number' => '465833123',
        'delivery_price' => 5,
        'pack_price' => 1,
        'img_url' => 'bd7a143e8ad95b6463ec368958372b2d.jpg',
        'categoryId' => $fixtureCat->getModel('chineseFood')->id
    ],
    'restaurant9' => [
        'restaurantName' => 'Alif kebab ',
        'tel_number' => '055777461',
        'delivery_price' => 1,
        'pack_price' => 1,
        'img_url' => 'a6e86a19e499a50f5742c207fba2bd2c.jpg',
        'categoryId' => $fixtureCat->getModel('kebab')->id
    ],
    'restaurant10' => [
        'restaurantName' => 'Cairo',
        'tel_number' => '763807098',
        'delivery_price' => 4,
        'pack_price' => 1,
        'img_url' => 'ef507d7116308ed4588319eec58a74eb.jpg',
        'categoryId' => $fixtureCat->getModel('kebab')->id
    ],
    'restaurant11' => [
        'restaurantName' => 'FILE RYB',
        'tel_number' => '694-425-421',
        'delivery_price' => 0,
        'pack_price' => 0,
        'img_url' => 'ef507d7116308ed4588319eec58a74eb.jpg',
        'categoryId' => $fixtureCat->getModel('polak')->id
    ],
];
