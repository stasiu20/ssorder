<?php

use yii\db\Migration;

/**
 * Class m200521_125902_restaurantPhoneLength
 */
class m200521_125902_restaurantPhoneLength extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = 'ALTER TABLE `restaurants` CHANGE `tel_number` `tel_number` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL;';
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
