<?php

use yii\db\Migration;

class m150428_095829_news_cat extends Migration
{
    public function safeUp()
    {
        $this->createTable('news_cat', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('news_cat');
    }
}
