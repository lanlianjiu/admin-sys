<?php

use yii\db\Migration;

/**
 * Class m180714_060809_add_field_access_token_to_user
 */
class m180714_060809_add_fields_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'access_token',
            $this->string('32')->notNull()->defaultValue('')->comment('用户登录验证token')
        );
        $this->addColumn('{{%user}}', 'expire_at',
            $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('access_token过期时间')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'access_token');
        $this->dropColumn('{{%user}}', 'expire_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180714_060809_add_field_access_token_to_user cannot be reverted.\n";

        return false;
    }
    */
}
