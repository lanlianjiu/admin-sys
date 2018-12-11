<?php

use yii\db\Migration;

/**
 * Class m180723_140501_user_init
 */
class m180723_140501_user_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}',[
            'username' => 'admin',
            'auth_key' => 'uMxuLdB5s6u9awgIwcEOk2kLMPYJnIfz',
            'password_hash' => '$2y$13$1IW/OUzM3pmgn96sl2WA/edpIl.5kqJRoDZH1b1NEUr3cVnQUogTe',
            'email' => 'admin@gmail.com',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180723_140501_user_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180723_140501_user_init cannot be reverted.\n";

        return false;
    }
    */
}
