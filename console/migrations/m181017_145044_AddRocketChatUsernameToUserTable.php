<?php

use yii\db\Migration;

class m181017_145044_AddRocketChatUsernameToUserTable extends Migration
{
    public function up()
    {
        $this->addColumn(\common\models\User::tableName(), 'rocketchat_id', 'varchar(35)');
    }

    public function down()
    {
        $this->dropColumn(\common\models\User::tableName(), 'rocketchat_id');
    }
}
