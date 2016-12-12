<?php

use yii\db\Migration;

class m150428_095829_news_cat extends Migration
{
    public function safeUp()
    {
        $this->createTable('news_cat', [
            'id' => 'pk',
            'title' => 'VARCHAR(150) NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('news_cat');
    }
}
