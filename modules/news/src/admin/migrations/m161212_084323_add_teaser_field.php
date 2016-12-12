<?php

use yii\db\Migration;

class m161212_084323_add_teaser_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('news_article', 'teaser_text', 'text');
    }

    public function safeDown()
    {
        $this->dropColumn('news_article', 'teaser_text');
    }
}
