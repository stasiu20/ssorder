<?php

use yii\db\Migration;

class m180420_142453_priceType extends Migration
{
    public function up()
    {
        $this->alterColumn(\frontend\models\Menu::tableName(), 'foodPrice', 'decimal(5,2)');
    }

    public function down()
    {
        $this->alterColumn(\frontend\models\Menu::tableName(), 'foodPrice', 'varchar(11)');
        return true;
    }
}
