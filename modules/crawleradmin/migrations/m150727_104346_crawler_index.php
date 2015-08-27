<?php

use yii\db\Migration;

class m150727_104346_crawler_index extends Migration
{
    public function up()
    {
        $this->createTable('crawler_index', [
            'id' => 'pk',
            'url' => 'varchar(200) NOT NULL',
            'content' => 'TEXT',
            'title' => 'varchar(200)',
            'added_to_index' => 'int(11)',
            'last_update' => 'int(11)',
            'arguments_json' => 'text NOT NULL',
            'language_info' => 'varchar(80)',
        ]);

        $this->createIndex('uniqueurl', 'crawler_index', 'url', true);
    }

    public function down()
    {
        echo "m150727_104346_crawler_index cannot be reverted.\n";

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
