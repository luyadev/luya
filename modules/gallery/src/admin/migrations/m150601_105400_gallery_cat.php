<?php

use yii\db\Migration;

class m150601_105400_gallery_cat extends Migration
{
    public function safeUp()
    {
        $this->createTable('gallery_cat', [
            'id' => $this->primaryKey(),
            'title' => $this->text()->notNull(),
            'cover_image_id' => $this->integer(11)->defaultValue(0),
            'description' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('gallery_cat');
    }
}
