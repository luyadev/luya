<?php

use yii\db\Migration;

class m150727_104346_crawler_index extends Migration
{
    public function safeUp()
    {
        $this->createTable('crawler_index', [
            'id' => $this->primaryKey(),
            'url' => $this->string(200)->notNull()->unique(),
            'title' => $this->string(200),
            'content' => $this->text(),
            'description' => $this->text(),
            'language_info' => $this->string(80),
            'url_found_on_page' => $this->string(255),
            'group' => $this->string(120),
            'added_to_index' => $this->integer(11)->defaultValue(0),
            'last_update' => $this->integer(11)->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('crawler_index');
    }
}
