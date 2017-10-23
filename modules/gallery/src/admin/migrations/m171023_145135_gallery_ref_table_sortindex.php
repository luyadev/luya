<?php

use yii\db\Migration;

class m171023_145135_gallery_ref_table_sortindex extends Migration
{
    public function safeUp()
    {
        $this->addColumn('gallery_album_image', 'sortindex', $this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('gallery_album_image', 'sortindex');
    }
}
