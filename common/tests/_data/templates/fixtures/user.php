<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'username' => $faker->userName,
    'email' => $faker->email,
    'status' => $faker->randomElement([\common\models\User::STATUS_ACTIVE, \common\models\User::STATUS_DELETED]),
    'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('password'),
    'password_reset_token' => null,
    'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
    'rocketchat_id' => null,
    'created_at' => $faker->unixTime,
    'updated_at' => $faker->unixTime
];
