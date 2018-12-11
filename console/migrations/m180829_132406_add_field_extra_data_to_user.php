<?php

use yii\db\Migration;

/**
 * Class m180829_132406_add_field_extra_data_to_user
 */
class m180829_132406_add_field_extra_data_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'extra_data',
            $this->text()->comment('存放json')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_132406_add_field_extra_data_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_132406_add_field_extra_data_to_user cannot be reverted.\n";

        return false;
    }
    */
}
