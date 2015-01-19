<?php
namespace cmsadmin\models;

/**
 * Each creation of a navigation block requires the nav_item_type_id which need to be created first with NavItemType Model
 *
 * @author nadar
 */
class NavItem extends \yii\db\ActiveRecord
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
            [['nav_id', 'lang_id', 'title', 'rewrite', 'nav_item_type', 'nav_item_type_id'], 'required']
        ];
    }

    public function getType()
    {
        switch ($this->nav_item_type) {
            case self::TYPE_PAGE:
                return \cmsadmin\models\NavItemPage::findOne($this->nav_item_type_id);
                break;
        }
    }

    /*
    public function getNav()
    {
        return $this->hasOne(\cmsadmin\models\Nav::className(), ['id' => 'nav_id']);
    }
    */

    /*
    public function createType($type)
    {
        switch($type) {
            case self::TYPE_PAGE:
                $model = new \cmsadmin\models\NavItemPage();
                $model->text = 'OK_I_AM_THE_TEXT_PROPERTY';
                break;
            case self::TYPE_MODULE:

                break;
            case self::TYPE_REDIRECT:

                break;
            default:
                throw new \Exception("wrong input type to create");
                break;
        }

        if($model->validate()) {
            $obj = $model->save();
            return $model->id;
        }
    }
    */

    public function verifyRewrite($rewrite, $langId)
    {
        return $this->find()->where(['rewrite' => $rewrite, 'lang_id' => $langId])->one();
    }

    public function validateRewrite()
    {
        if (!is_null($this->verifyRewrite($this->rewrite, $this->lang_id))) {
            $this->addError('rewrite', 'Rewrite existiert bereits!');
            return false;
        }
        
        return true;
    }
    
    public function beforeCreate()
    {
        $this->is_hidden = 1;
        $this->is_inactive = 0;
        $this->timestamp_create = time();
        $this->timestamp_update = 0;
        $this->create_user_id = \admin\Module::getAdminUserData()->id;
        $this->update_user_id = \admin\Module::getAdminUserData()->id;
    }
}
