<?php

use yii\db\Schema;
use yii\db\Migration;

class m151116_105124_image_resolution_to_storage_image extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_storage_image', 'resolution_width', $this->integer(11));
        $this->addColumn('admin_storage_image', 'resolution_height', $this->integer(11));
    }

    public function safeDown()
    {
    	$this->dropColumn('admin_storage_image', 'resolution_width');
    	$this->dropColumn('admin_storage_image', 'resolution_height');
    }
}
