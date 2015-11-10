<?php

use yii\db\Migration;

class m151013_132217_login_secure_token extends Migration
{
    public function up()
    {
        $this->addColumn('admin_user', 'secure_token', 'varchar(40)');
        $this->addColumn('admin_user', 'secure_token_timestamp', 'int(11) default 0');
    }

    public function down()
    {
        echo "m151013_132217_login_secure_token cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
