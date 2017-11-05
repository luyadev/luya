<?php

use yii\db\Migration;

/**
 *
 * @todo Remove in 1.0.1 release!
 * @author Basil Suter <basil@nadar.io>
 */
class m170926_144137_add_admin_user_session_id_column extends Migration
{
    public function safeUp()
    {
        $this->addColumn('admin_user_login', 'session_id', $this->string()->notNull()->defaultValue(null)); // default value supports upgrading and sync from previous system.s
    }

    public function safeDown()
    {
        $this->dropColumn('admin_user_login', 'session_id');
    }
}
