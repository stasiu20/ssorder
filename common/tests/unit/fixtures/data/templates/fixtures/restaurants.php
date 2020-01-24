<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'restaurantName' => $faker->words(3, true),
    'tel_number' => $faker->numerify('#########'),
    'delivery_price' => round($faker->randomFloat(2, 0, 2), 2),
    'pack_price' => round($faker->randomFloat(2, 0, 2), 2),
    'img_url' => $faker->image(Yii::getAlias('@frontend/web/image'), 640, 480, null, false),
    'categoryId' => $faker->numberBetween(1, 5)
];
