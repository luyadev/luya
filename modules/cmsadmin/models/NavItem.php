<?php

namespace cmsadmin\models;

use Yii;
use admin\models\Lang;

/**
 * Each creation of a navigation block requires the nav_item_type_id which need to be created first with NavItemType Model.
 *
 * @author nadar
 */
class NavItem extends \yii\db\ActiveRecord implements \admin\base\GenericSearchInterface
{
    const TYPE_PAGE = 1;

    const TYPE_MODULE = 2;

    const TYPE_REDIRECT = 3;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'validateRewrite']);
        
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'logEvent']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'logEvent']);
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'logEvent']);
    }

    public function logEvent($e)
    {
        switch($e->name) {
            case "afterInsert":
                Log::add(1, "nav_item.insert '".$this->title."', cms_nav_item.id '".$this->id."'", $this->toArray());
                break;
            case "afterUpdate":
                Log::add(2, "nav_item.update '".$this->title."', cms_nav_item.id '".$this->id."'", $this->toArray());
                break;
            case "afterDelete":
                Log::add(3, "nav_item.delete '".$this->title."', cms_nav_item.id '".$this->id."'", $this->toArray());
                break;
        }
    }
    
    public static function tableName()
    {
        return 'cms_nav_item';
    }

    public function rules()
    {
        return [
            [['lang_id', 'title', 'rewrite', 'nav_item_type'], 'required'],
            [['rewrite'], 'validateRewrite', 'on' => ['meta']],
            [['nav_id'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['title', 'rewrite', 'nav_item_type', 'nav_id', 'lang_id'],
            'meta' => ['title', 'rewrite'],
        ];
    }

    public function getType()
    {
        switch ($this->nav_item_type) {
            case self::TYPE_PAGE:
                $object = NavItemPage::findOne($this->nav_item_type_id);
                break;
            case self::TYPE_MODULE:
                $object = NavItemModule::findOne($this->nav_item_type_id);
                break;
        }
        $object->setNavItem($this);

        return $object;
    }

    public function getNav()
    {
        return Nav::find()->where(['id' => $this->nav_id])->one();
    }

    public function getContent()
    {
        return $this->getType()->getContent();
    }

    public function updateType($postData)
    {
        $model = $this->getType();
        $model->attributes = $postData;

        return $model->update();
    }

    public function verifyRewrite($rewrite, $langId)
    {
        if (Yii::$app->hasModule($rewrite)) {
            $this->addError('rewrite', 'Die URL darf nicht verwendet werden da es ein Modul mit dem gleichen Namen gibt.');

            return false;
        }

        if ($this->find()->where(['rewrite' => $rewrite, 'lang_id' => $langId])->one()) {
            $this->addError('rewrite', 'Diese URL existiert bereits und ist deshalb ungültig');

            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Seitentitel',
            'rewrite' => 'Pfadsegment',
        ];
    }

    public function validateRewrite()
    {
        $dirty = $this->getDirtyAttributes(['rewrite']);
        if (!isset($dirty['rewrite'])) {
            return true;
        }

        if (!$this->verifyRewrite($this->rewrite, $this->lang_id)) {
            return false;
        }
    }

    public function beforeCreate()
    {
        $this->timestamp_create = time();
        $this->timestamp_update = 0;
        $this->create_user_id = Yii::$app->adminuser->getId();
        $this->update_user_id = Yii::$app->adminuser->getId();
    }

    /**
     * temp disabled the links for the specific module, cause we are not yet able to handle module integration blocks (find the module inside the content), so wo just
     * display all nav items tempo.
     * 
     * @todo fix me above!
     *
     * @param unknown $moduleName
     */
    public static function fromModule($moduleName)
    {
        return self::find()->all();
        //return self::find()->leftJoin('cms_nav_item_module', 'nav_item_type_id=cms_nav_item_module.id')->where(['nav_item_type' => 2, 'cms_nav_item_module.module_name' => $moduleName])->all();
    }

    /* GenericSearchInterface */

    public function genericSearchFields()
    {
        return ['title', 'rewrite'];
    }

    public function genericSearch($searchQuery)
    {
        $query = self::find();
        $fields = $this->genericSearchFields();
        foreach ($fields as $field) {
            $query->orWhere(['like', $field, $searchQuery]);
        }

        return $query->select($fields)->asArray()->all();
    }

    /**
     * @todo use AR or queryCommand? NavItem::find()->leftJoin('cms_nav_item_module', 'nav_item_type_id=cms_nav_item_module.id')->where(['nav_item_type' => 2, 'cms_nav_item_module.module_name' => $moduleName])->asArray()->one()
     * @param unknown $moduleName
     * @return unknown
     */
    public static function findNavItem($moduleName)
    {
        // current active lang:
        $default = Lang::findActive();

        $query = Yii::$app->db->createCommand('SELECT i.* FROM cms_nav_item as i LEFT JOIN (cms_nav_item_module as m) ON (i.nav_item_type_id=m.id) WHERE i.nav_item_type=2 AND i.lang_id=:lang_id AND m.module_name=:module')->bindValues([
            ':module' => $moduleName, ':lang_id' => $default['id'],
        ])->queryOne();

        return $query;
    }
}
