<?php

use yii\db\Schema;
use yii\db\Migration;

class m150311_123919_news_tag extends Migration
{
    public function up()
    {
        $this->createTable('news_tag', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        echo "m150311_123919_news_tag cannot be reverted.\n";

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
