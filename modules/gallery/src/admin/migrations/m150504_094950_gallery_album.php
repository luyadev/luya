<?php

use yii\db\Migration;

class m150504_094950_gallery_album extends Migration
{
    public function up()
    {
        $this->createTable('gallery_album', [
            'id' => 'pk',
            'cat_id' => 'int(11) NOT NULL default 0',
            'title' => 'varchar(150) NOT NULL',
            'description' => 'text',
            'cover_image_id' => 'int(11) default 0',
            'timestamp_create' => 'int(11) NOT NULL default 0',
            'timestamp_update' => 'int(11) NOT NULL default 0',
        ]);
    }

    public function down()
    {
        echo "m150504_094950_gallery_album cannot be reverted.\n";

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
