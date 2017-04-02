<?php

use yii\db\Migration;

class m170113_202519_crawler_click extends Migration
{
    public function safeUp()
    {
        $this->createTable('crawler_click', [
            'id' => $this->primaryKey(),
            'searchdata_id' => $this->integer(11)->notNull(),
            'position' => $this->integer(11)->notNull(),
            'index_id' => $this->integer(11)->notNull(),
            'timestamp' => $this->integer(11)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('crawler_click');
    }
}
