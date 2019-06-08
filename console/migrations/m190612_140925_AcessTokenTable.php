<?php

use yii\db\Migration;

/**
 * Class m190612_140925_AcessTokenTable
 */
class m190612_140925_AcessTokenTable extends Migration
{

    public function up()
    {
        $sql = 'CREATE TABLE `access_token` (
  `token` varchar(1000) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
        $this->execute($sql);

        $this->addPrimaryKey('access_token_pk', 'access_token', ['token', 'user_id']);
        $this->createIndex('token_uniq', 'access_token', 'token', true);
    }

    public function down()
    {
        $this->dropTable('access_token');
    }
}
