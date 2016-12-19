<?php

use yii\db\Migration;

class m150204_144806_news_article extends Migration
{
    public function safeUp()
    {
        $this->createTable('news_article', [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'text' => $this->text(),
            'cat_id' => $this->integer(11)->defaultValue(0),
            'image_id' => $this->integer(11)->defaultValue(0),
            'image_list' => $this->text(),
            'file_list' => $this->text(),
            'create_user_id' => $this->integer(11)->defaultValue(0),
            'update_user_id' => $this->integer(11)->defaultValue(0),
            'timestamp_create' => $this->integer(11)->defaultValue(0),
            'timestamp_update' => $this->integer(11)->defaultValue(0),
            'timestamp_display_from' => $this->integer(11)->defaultValue(0),
            'timestamp_display_until' => $this->integer(11)->defaultValue(0),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'is_display_limit' => $this->boolean()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('news_article');
    }
}