<?php
namespace cmsadmin\models;

class NavItemPageBlockItem extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_FIND, [$this, 'afterFind']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'beforeUpdate']);
    }

    public static function tableName()
    {
        return 'cms_nav_item_page_block_item';
    }


    public function scenarios()
    {
        return [
            'restcreate' => ['block_id', 'placeholder_var', 'nav_item_page_id', 'json_config_values', 'prev_id'],
            'restupdate' => ['block_id', 'placeholder_var', 'nav_item_page_id', 'json_config_values', 'prev_id'],
        ];
    }
    
    public function beforeUpdate()
    {
        $this->json_config_values = json_encode($this->json_config_values);
    }
    
    public function afterFind()
    {
        $this->json_config_values = json_decode($this->json_config_values, true);
    }

    public function getBlock()
    {
        return $this->hasOne(\cmsadmin\models\Block::className(), ['id' => 'block_id']);
    }
}
