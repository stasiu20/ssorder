<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191223_080808_foodRating
 */
class m191223_080808_foodRating extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('food_rating', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
            'rating' => $this->smallInteger(),
            'date' => $this->dateTime(),
            'review' => $this->string(1000)->notNull()->defaultValue(''),
        ]);
        $this->addForeignKey('fk_food_rating_order_id_order_id', 'food_rating', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_food_rating_user_id_user_id', 'food_rating', 'user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_food_rating_order_id_order_id', 'food_rating');
        $this->dropForeignKey('fk_food_rating_user_id_user_id', 'food_rating');
        $this->dropTable('food_rating');
    }
}
