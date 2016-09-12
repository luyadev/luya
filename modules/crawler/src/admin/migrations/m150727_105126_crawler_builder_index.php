<?php

use yii\db\Migration;

class m150727_105126_crawler_builder_index extends Migration
{
    public function up()
    {
        $this->createTable('crawler_builder_index', [
            'id' => 'pk',
            'url' => 'varchar(200) NOT NULL',
            'content' => 'TEXT',
            'title' => 'varchar(200)',
            'last_indexed' => 'int(11)',
            'arguments_json' => 'text NOT NULL', // removed in beta3
            'language_info' => 'varchar(80)',
            'crawled' => 'tinyint(1) default 0',
            'status_code' => 'tinyint(4) default 0',
        ]);

        $this->createIndex('uniqueurl', 'crawler_builder_index', 'url', true);
    }

    public function down()
    {
        echo "m150727_105126_crawler_builder_index cannot be reverted.\n";

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
