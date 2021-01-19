<?php

use yii\db\Migration;

/**
 * Class m210119_203402_insert_root_user_into_user_table
 */
class m210119_203402_insert_root_user_into_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(
            '{{%user}}',
            [
                'username' => 'root',
                'auth_key' => 'iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv',
                'password_hash' => '$2y$13$EjaPFBnZOQsHdGuHI.xvhuDp1fHpo8hKRSk6yshqa9c5EG8s3C3lO',
                // password_0
                'password_reset_token' => 't5GU9NwpuGYSfb7FEZMAxqtuz2PkEvv_' . time(),
                'created_at' => '1391885313',
                'updated_at' => '1391885313',
                'email' => 'brady.renner@rutherford.com'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(
            '{{%user}}',
            ['username' => 'root']
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210119_203402_insert_root_user_into_user_table cannot be reverted.\n";

        return false;
    }
    */
}
