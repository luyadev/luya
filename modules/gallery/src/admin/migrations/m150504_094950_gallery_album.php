<?php

use yii\db\Migration;

class m150504_094950_gallery_album extends Migration
{
    public function safeUp()
    {
        $this->createTable('gallery_album', [
            'id' => $this->primaryKey(),
            'cat_id' => $this->integer()->defaultValue(0),
            'title' => $this->text()->notNull(),
            'description' => $this->text(),
            'cover_image_id' => $this->integer(11)->defaultValue(0),
            'timestamp_create' => $this->integer(0)->defaultValue(0),
            'timestamp_update' => $this->integer(0)->defaultValue(0),
            'is_highlight' => $this->boolean()->defaultValue(false),
            'sort_index' => $this->integer()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('gallery_album');
    }
}
