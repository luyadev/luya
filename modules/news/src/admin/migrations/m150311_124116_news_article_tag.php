<?php

use yii\db\Schema;
use yii\db\Migration;

class m150311_124116_news_article_tag extends Migration
{
    public function up()
    {
        $this->createTable('news_article_tag', [
            'id' => 'pk',
            'article_id' => Schema::TYPE_INTEGER,
            'tag_id' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        echo "m150311_124116_news_article_tag cannot be reverted.\n";

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
