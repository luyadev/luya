<?php

use yii\db\Migration;

class m150727_105126_crawler_builder_index extends Migration
{
    public function safeUp()
    {
        $this->createTable('crawler_builder_index', [
            'id' => $this->primaryKey(),
            'url' => $this->string(200)->notNull()->unique(),
            'title' => $this->string(200),
            'content' => $this->text(),
            'description' => $this->text(),
            'language_info' => $this->string(80),
            'url_found_on_page' => $this->string(255),
            'group' => $this->string(120),
            'last_indexed' => $this->integer(11),
            'crawled' => $this->boolean()->defaultValue(false),
            'status_code' => $this->smallInteger(4)->defaultValue(0),
            'content_hash' => $this->string(80),
            'is_dublication' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('crawler_builder_index');
    }
}
