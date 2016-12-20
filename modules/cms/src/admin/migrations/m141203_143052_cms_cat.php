<?php

use yii\db\Migration;

/**
 * Cms Nav Container.
 *
 * The table has been renamed in later version and the ohter migrations has been removed, but the of the migration file
 * is the same in order to keep the migration history.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class m141203_143052_cms_cat extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_container', [
            'id' => $this->primaryKey(),
            'name' => $this->string(180)->notNull(),
            'alias' => $this->string(180)->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_container');
    }
}
