<?php

use yii\db\Migration;

/**
 * Class m180725_133107_modify_fields_to_user
 */
class m180725_133107_modify_fields_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'access_token',
            $this->string('255')->notNull()->defaultValue('')->comment('用户登录验证JWT')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'access_token',
            $this->string('32')->notNull()->defaultValue('')->comment('用户登录验证token')
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180725_133107_modify_fields_to_user cannot be reverted.\n";

        return false;
    }
    */
}
