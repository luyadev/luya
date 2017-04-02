<?php

use yii\db\Migration;

class m150504_132138_gallery_album_image extends Migration
{
    public function safeUp()
    {
        $this->createTable('gallery_album_image', [
            'image_id' => $this->integer(11)->notNull(),
            'album_id' => $this->integer(11)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('gallery_album_image');
    }
}
