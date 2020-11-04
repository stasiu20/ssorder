<?php

use yii\db\Migration;

/**
 * Class m201031_085957_CreateUserSubscription
 *
 * Only for BC, we want migrate all migrations from Yii2 to Symfony app
 *
 * @see \DoctrineMigrations\Version20201031085422
 */
class m201031_085957_CreateUserSubscription extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TABLE user_subscription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, subscription_hash VARCHAR(255) NOT NULL, subscription LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_230A18D1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->execute('ALTER TABLE user_subscription ADD CONSTRAINT FK_230A18D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_subscription');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201031_085957_CreateUserSubscription cannot be reverted.\n";

        return false;
    }
    */
}
