<?php

namespace luya\gallery\models;

use luya\gallery\admin\Module;

class Cat extends \luya\admin\ngrest\base\NgRestModel
{
    /* yii model properties */

    public static function tableName()
    {
        return 'gallery_cat';
    }

    public function rules()
    {
        return [
            ['title', 'required', 'message' => Module::t('cat_title_create_error')],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'cover_image_id', 'description'],
            'restupdate' => ['title', 'cover_image_id', 'description'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Module::t('cat_title'),
            'description' => Module::t('cat_description'),
            'cover_image_id' => Module::t('cat_cover_image_id'),
        ];
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
    }

    public function eventBeforeDelete($event)
    {
        $items = Album::find()->where(['cat_id' => $this->id])->all();

        if (count($items) > 0) {
            $this->addError('id', Module::t('cat_delete_error'));
            $event->isValid = false;

            return;
        }

        $event->isValid = true;
    }

    // ngrest

    public $i18n = ['title', 'description'];

    public static function ngRestApiEndpoint()
    {
        return 'api-gallery-cat';
    }

    public function ngRestAttributeTypes()
    {
        return [
            'title' => 'text',
            'description' => 'text',
            'cover_image_id' => 'image',
        ];
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['title', 'description']);

        $config->create->copyFrom('list', ['id']);
        $this->ngRestConfigDefine($config, 'create', ['cover_image_id']);
        $config->update->copyFrom('create');

        $config->delete = true;

        return $config;
    }
}
