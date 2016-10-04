<?php

use yii\db\Schema;
use yii\db\Migration;

class m151013_084408_add_http_auth extends Migration
{
    public function up()
    {
        $this->addColumn('remote_site', 'auth_is_enabled', 'TINYINT(1) DEFAULT 0');
        $this->addColumn('remote_site', 'auth_user', 'VARCHAR(120)');
        $this->addColumn('remote_site', 'auth_pass', 'VARCHAR(120)');
    }

    public function down()
    {
        echo "m151013_084408_add_http_auth cannot be reverted.\n";

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
