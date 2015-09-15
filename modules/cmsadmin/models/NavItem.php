<?php

namespace cmsadmin\models;

use Yii;

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
                return \cmsadmin\models\NavItemPage::findOne($this->nav_item_type_id);
                break;
            case self::TYPE_MODULE:
                return \cmsadmin\models\NavItemModule::findOne($this->nav_item_type_id);
                break;
        }
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
}
