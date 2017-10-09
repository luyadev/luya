<?php

use yii\db\Migration;

/**
 * Handles adding class to table `block_group`.
 */
class m171003_065811_add_class_column_to_block_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('cms_block_group', 'class', $this->string()->notNull()->defaultValue(null)); // default value supports upgrading and sync from previous system.s
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('cms_block_group', 'class');
    }
}
