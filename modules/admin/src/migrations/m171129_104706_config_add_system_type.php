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
        // remove old name primary key
        $this->dropPrimaryKey('name', 'admin_config');
        // add new id field as primary key
        $this->addColumn('admin_config', 'id', $this->primaryKey());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('admin_config', 'is_system');
        // add new id field as primary key
        $this->dropColumn('admin_config', 'id');
        // remove old name primary key
        $this->addPrimaryKey('name', 'admin_config', ['name']);
    }
}
