<?php
namespace cmsadmin\models;

class Nav extends \yii\db\ActiveRecord
{
    public $title;
    public $rewrite;
    public $nav_item_type;
    public $nav_item_type_id;
    public $lang_id;

    public static function tableName()
    {
        return 'cms_nav';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'afterCreate']);
    }

    public function rules()
    {
        return [
            [['cat_id', 'parent_nav_id', 'sort_index', 'is_deleted'], 'integer', 'on' => 'restcreate']
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['cat_id', 'lang_id', 'parent_nav_id', 'nav_item_type', 'nav_item_type_id', 'sort_index', 'is_deleted', 'title', 'rewrite'],
            'restupdate' => []
        ];
    }

    public function beforeCreate()
    {
        $this->is_deleted = 0;
    }

    public function transactions()
    {
        return [
            'restcreate' => self::OP_ALL
        ];
    }

    public function afterCreate()
    {
        $navItem = new NavItem();
        $navItem->nav_item_type = $this->nav_item_type;
        $navItem->nav_item_type_id = $this->nav_item_type_id;
        $navItem->nav_id = $this->id;
        $navItem->lang_id = $this->lang_id;
        $navItem->title = $this->title;
        $navItem->rewrite = $this->rewrite;
        if ($navItem->validate()) {
            $navItem->save();
        } else {
            throw new \Exception(print_r($navItem->getErrors(), true));
        }
    }
    /*
    public function getNavItems()
    {
        return $this->hasMany(\cmsadmin\models\NavItem::className(), ['nav_id' => 'id']);
    }


    public function getItems()
    {
        // return hasMany
    }
    */

    public function getItem($langId)
    {
        return \cmsadmin\models\NavItem::find()->where(['nav_id' => $this->id, 'lang_id' => $langId])->one();
    }

    public static function getItemsData($navId)
    {
        return \yii::$app->db->createCommand('SELECT t1.id, t1.parent_nav_id, t2.id as nav_item_id, t2.title, t2.rewrite, t3.rewrite AS cat_rewrite, t4.name AS lang_name, t4.short_code AS lang_short_code FROM cms_nav as t1 LEFT JOIN (cms_nav_item as t2 LEFT JOIN (admin_lang as t4) ON (t2.lang_id=t4.id), cms_cat as t3) ON (t1.id=t2.nav_id AND t1.cat_id=t3.id) WHERE t1.parent_nav_id=:id')->bindValues([
            ':id' => $navId,
        ])->queryAll();
    }
}
