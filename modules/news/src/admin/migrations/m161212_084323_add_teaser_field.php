<?php

use yii\db\Migration;

class m161212_084323_add_teaser_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('news_article', 'teaser_text', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('news_article', 'teaser_text');
    }
}
