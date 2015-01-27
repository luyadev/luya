<?php
namespace admin\models;

class Lang extends \admin\ngrest\base\Model
{
    public $ngRestEndpoint = 'api-admin-lang';
    
    public function ngRestConfig($config)
    {
        
        $config->i18n(['name']);
        
        $config->list->field("name", "Name")->text()->required();
        $config->list->field("short_code", "Kurz-Code")->text()->required();
        $config->list->field("id", "ID")->text();
        
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        
        return $config;
    }
    
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'beforeUpdate']);
        $this->on(self::EVENT_AFTER_FIND, [$this, 'afterFind']);
    }
    
    public function afterFind()
    {
        $this->name = json_decode($this->name, true);
    }

    public static function tableName()
    {
        return 'admin_lang';
    }

    public function rules()
    {
        return [
            [['name', 'short_code'], 'required']
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'short_code'],
            'restupdate' => ['name', 'short_code']
        ];
    }
    public function beforeUpdate()
    {
        $this->name = json_encode($this->name);
    }
    
    public function beforeCreate()
    {
        $this->name = json_encode($this->name);
        $this->is_default = 0;
    }

    public static function getDefault()
    {
        return self::find()->where(['is_default' => 1])->one();
    }
}
