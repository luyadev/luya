<?php

use yii\db\Schema;
use yii\db\Migration;

class m150204_144806_news_article extends Migration
{
    public function up()
    {
        $this->createTable('news_article', [
            'id' => 'pk',
            'title' => Schema::TYPE_TEXT,
            'text' => Schema::TYPE_TEXT,
            'cat_id' => 'int(11) NOT NULL default 0',
            'image_id' => Schema::TYPE_INTEGER,
            'image_list' => Schema::TYPE_TEXT,
            'file_list' => Schema::TYPE_TEXT,
            'create_user_id' => Schema::TYPE_INTEGER,
            'update_user_id' => Schema::TYPE_INTEGER,
            'timestamp_create' => Schema::TYPE_INTEGER,
            'timestamp_update' => Schema::TYPE_INTEGER,
            'timestamp_display_from' => Schema::TYPE_INTEGER,
            'timestamp_display_until' => Schema::TYPE_INTEGER,
            'is_deleted' => 'tinyint(1) NOT NULL DEFAULT 0',
            'is_display_limit' => 'tinyint(1) NOT NULL DEFAULT 0',
        ]);
    }

    public function down()
    {
        echo "m150204_144806_news_article cannot be reverted.\n";

        return false;
    }
}
