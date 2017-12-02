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
            'event_id' => $this->integer(),
            'category_id' => $this->integer(),
            'amount' => $this->string()->notNull(),
        ]);
        
        // we could also just so a primary key for the junction table, but we want to have a far more complex usacse.
        $this->addPrimaryKey('ngresttest_price_pk', 'ngresttest_price', ['event_id', 'category_id']);
        
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
        echo "m171202_113422_issue1682 cannot be reverted.\n";

        return false;
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
