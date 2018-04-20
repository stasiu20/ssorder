<?php

use yii\db\Migration;

class m180420_150047_orderPrice extends Migration
{
    public function up()
    {
        $this->addColumn(\common\models\Order::tableName(), 'price', 'decimal(5,2)');
    }

    public function down()
    {
        $this->dropColumn(\common\models\Order::tableName(), 'price');
    }
}
