<?php

use yii\db\Migration;

class m170116_120553_cms_block_variation_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cms_nav_item_page_block_item', 'variation', $this->string(255)->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('cms_nav_item_page_block_item', 'variation');
    }
}
