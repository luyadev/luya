<?php

use yii\db\Migration;

class m150626_084948_admin_search_data extends Migration
{
    public function up()
    {
        $this->createTable('admin_search_data', [
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'timestamp_create' => 'int(11) NOT NULL',
            'query' => 'varchar(200) NOT NULL',
            'num_rows' => 'int(11) NOT NULL DEFAULT 0',
        ]);
    }

    public function down()
    {
        echo "m150626_084948_admin_search_data cannot be reverted.\n";

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
