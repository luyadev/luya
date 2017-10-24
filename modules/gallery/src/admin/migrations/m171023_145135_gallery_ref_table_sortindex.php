<?php

use yii\db\Migration;

class m171023_145135_gallery_ref_table_sortindex extends Migration
{
    public function safeUp()
    {
        $this->addColumn('gallery_album_image', 'sortindex', $this->integer()->defaultValue(0));
        $this->addPrimaryKey('gallery_album_image_pk', 'gallery_album_image', ['image_id', 'album_id']);
    }

    public function safeDown()
    {
        $this->dropColumn('gallery_album_image', 'sortindex');
        $this->dropPrimaryKey('gallery_album_image_pk', 'gallery_album_image');
    }
}
