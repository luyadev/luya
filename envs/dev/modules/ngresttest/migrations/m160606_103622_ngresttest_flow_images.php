<?php

use yii\db\Migration;

class m160606_103622_ngresttest_flow_images extends Migration
{
   
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('ngresttest_table_images', [
            'model_id' => 'int(11) NOT NULL',
            'image_id' => 'int(11) NOT NULL',
            'sort_index' => 'int(11) NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('ngresttest_table_images');
    }
}
