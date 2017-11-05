<?php

use yii\db\Migration;

class m170619_103728_cms_blocksettings extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cms_block', 'is_disabled', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('cms_block', 'is_disabled');
    }
}
