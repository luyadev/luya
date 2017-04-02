<?php

use yii\db\Migration;

class m160524_134433_searchindex extends Migration
{
    public function safeUp()
    {
        $this->createTable('crawler_searchdata', [
            'id' => 'pk',
            'query' => 'varchar(120) NOT NULL',
            'results' => 'int(11) default 0',
            'timestamp' => 'int(11) NOT NULL',
            'language' => 'varchar(12)',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('crawler_searchdata');
    }
}
