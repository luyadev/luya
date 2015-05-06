<?php

use yii\db\Migration;

class m150504_132138_gallery_album_image extends Migration
{
    public function up()
    {
        $this->createTable('gallery_album_image', [
            'image_id' => 'int(11) NOT NULL default 0',
            'album_id' => 'int(11) NOT NULL default 0',
        ]);
    }

    public function down()
    {
        echo "m150504_132138_gallery_album_image cannot be reverted.\n";

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
