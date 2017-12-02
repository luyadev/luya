<?php

use yii\db\Migration;

/**
 * Class m171202_113422_issue1682
 */
class m171202_113422_issue1682 extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('ngresttest_event', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        $this->createTable('ngresttest_price', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'amount' => $this->string()->notNull(),
        ]);
        
        $this->createTable('ngresttest_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('ngresttest_event');
        $this->dropTable('ngresttest_price');
        
        $this->dropTable('ngresttest_category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171202_113422_issue1682 cannot be reverted.\n";

        return false;
    }
    */
}
