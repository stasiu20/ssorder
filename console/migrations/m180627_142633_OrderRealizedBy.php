<?php

use yii\db\Migration;

class m180627_142633_OrderRealizedBy extends Migration
{
    public function up()
    {
        $this->addColumn(\common\models\Order::tableName(), 'realizedBy', 'INT(11)');
        $this->addForeignKey(
            'fk_order_realizedBy_user_id',
            \common\models\Order::tableName(),
            'realizedBy',
            \common\models\User::tableName(),
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_order_realizedBy_user_id', \common\models\Order::tableName());
        $this->dropColumn(\common\models\Order::tableName(), 'realizedBy');
    }
}
