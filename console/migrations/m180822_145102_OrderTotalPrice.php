<?php

use yii\db\Migration;

class m180822_145102_OrderTotalPrice extends Migration
{
    public function up()
    {
        $this->addColumn(\common\models\Order::tableName(), 'total_price', 'decimal(5,2)');
    }

    public function down()
    {
        $this->dropColumn(\common\models\Order::tableName(), 'total_price');
    }
}
