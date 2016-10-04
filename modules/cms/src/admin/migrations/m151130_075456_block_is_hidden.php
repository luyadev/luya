<?php

use yii\db\Schema;
use yii\db\Migration;

class m151130_075456_block_is_hidden extends Migration
{
    public function up()
    {
        $this->addColumn("cms_nav_item_page_block_item", "is_hidden", "tinyint(1) default 0");
    }

    public function down()
    {
        echo "m151130_075456_block_is_hidden cannot be reverted.\n";

        return false;
    }
}
