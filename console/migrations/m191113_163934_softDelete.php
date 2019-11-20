<?php

use common\models\Order;
use yii\db\Migration;

/**
 * Class m191113_163934_softDelete
 */
class m191113_163934_softDelete extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'deletedAt', $this->dateTime()->null());
        $this->addColumn('category', 'deletedAt', $this->dateTime()->null());
        $this->addColumn('imagesmenu', 'deletedAt', $this->dateTime()->null());
        $this->addColumn('menu', 'deletedAt', $this->dateTime()->null());
        $this->addColumn('restaurants', 'deletedAt', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'deletedAt');
        $this->dropColumn('category', 'deletedAt');
        $this->dropColumn('imagesmenu', 'deletedAt');
        $this->dropColumn('menu', 'deletedAt');
        $this->dropColumn('restaurants', 'deletedAt');
    }
}
