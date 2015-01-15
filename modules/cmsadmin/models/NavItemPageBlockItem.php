<?php
namespace cmsadmin\models;

class NavItemPageBlockItem extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_FIND, [$this, 'afterFind']);
    }

    public static function tableName()
    {
        return 'cms_nav_item_page_block_item';
    }

    public function rules()
    {
        return [
            [['block_id', 'placeholder_var', 'nav_item_page_id', 'prev_id'], 'required'],
            [['json_config_values'], 'safe']
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['block_id', 'placeholder_var', 'nav_item_page_id', 'prev_id'],
            'restupdate' => ['block_id', 'json_config_values', 'prev_id'],
        ];
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
