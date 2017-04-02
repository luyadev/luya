<?php

use yii\db\Migration;

class m160321_125556_ngresttest extends Migration
{
    public function up()
    {
        $this->createTable('ngresttest_table', [
            'id' => 'pk',
            'image' => 'text',
            'imageArray' => 'text',
            'file' => 'text',
            'fileArray' => 'text',
            'text' => 'text',
            'textarea' => 'text',
            'selectArray' => 'text',
            'checkboxList' => 'text',
            'checkboxRelation' => 'text',
            'color' => 'text',
            'date' => 'text',
            'datetime' => 'text',
            'decimal' => 'text',
            'number' => 'text',
            'password' => 'text',
            'selectClass' => 'text',
            'toggleStatus' => 'text',
            'sortRelationArray' => 'text',
            'sortRelationModel' => 'text',
            
            // i18n

            'i18n_image' => 'text',
            'i18n_imageArray' => 'text',
            'i18n_file' => 'text',
            'i18n_fileArray' => 'text',
            'i18n_text' => 'text',
            'i18n_textarea' => 'text',
            'i18n_selectArray' => 'text',
            'i18n_checkboxList' => 'text',
            'i18n_checkboxRelation' => 'text',
            'i18n_color' => 'text',
            'i18n_date' => 'text',
            'i18n_datetime' => 'text',
            'i18n_decimal' => 'text',
            'i18n_number' => 'text',
            'i18n_password' => 'text',
            'i18n_selectClass' => 'text',
            'i18n_toggleStatus' => 'text',
            'i18n_sortRelationArray' => 'text',
            'i18n_sortRelationModel' => 'text',
        ]);
    }

    public function down()
    {
        echo "m160321_125556_ngresttest cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
