<?php

use yii\db\Migration;

class m160603_080705_album_add_sortindex_highlight extends Migration
{
    public function safeUp()
    {
        $this->addColumn('gallery_album', 'is_highlight', 'tinyint(1) NOT NULL default 0');
        $this->addColumn('gallery_album', 'sort_index', 'int(11) NOT NULL DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn('gallery_album', 'is_highlight');
        $this->dropColumn('gallery_album', 'sort_index');
    }
}
