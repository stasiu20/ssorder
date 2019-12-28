<?php

use yii\db\Migration;

/**
 * Class m191227_104729_renameAccessTokenTable
 */
class m191227_104729_renameAccessTokenTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('access_token', 'access_token_to_delete');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('access_token_to_delete', 'access_token');
    }
}
