<?php

use yii\db\Migration;

class m180704_143724_PayAmmount extends Migration
{
    public function up()
    {
        $this->addColumn(\common\models\Order::tableName(), 'pay_amount', 'decimal(5,2)');
    }

    public function down()
    {
        $this->dropColumn(\common\models\Order::tableName(), 'pay_amount');
    }
}
