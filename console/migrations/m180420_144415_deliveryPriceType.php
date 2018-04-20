<?php

use yii\db\Migration;

class m180420_144415_deliveryPriceType extends Migration
{
    public function up()
    {
        $this->alterColumn(\frontend\models\Restaurants::tableName(), 'delivery_price', 'decimal(5,2)');
    }

    public function down()
    {
        $this->alterColumn(\frontend\models\Restaurants::tableName(), 'delivery_price', 'varchar(11)');
        return true;
    }
}
