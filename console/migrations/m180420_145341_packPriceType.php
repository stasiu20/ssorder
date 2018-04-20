<?php

use yii\db\Migration;

class m180420_145341_packPriceType extends Migration
{
    public function up()
    {
        $this->alterColumn(\frontend\models\Restaurants::tableName(), 'pack_price', 'decimal(5,2)');
    }

    public function down()
    {
        $this->alterColumn(\frontend\models\Restaurants::tableName(), 'pack_price', 'varchar(11)');
        return true;
    }
}
