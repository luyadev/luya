<?php

use yii\db\Migration;

/**
 * Class m171129_104706_config_add_system_type
 */
class m171129_104706_config_add_system_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('admin_config', 'is_system', $this->boolean()->defaultValue(true));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('admin_config', 'is_system');
    }
}
