<?php

namespace ngresttest\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\DetailViewActiveWindow;

/**
 * Category.
 * 
 * File has been created with `crud/create` command on LUYA version 1.0.0-dev. 
 *
 * @property integer $id
 * @property string $name
 */
class Category extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ngresttest_category';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-ngresttest-category';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function ngRestActiveWindows()
    {
        return [
            'class' => DetailViewActiveWindow::class,
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['name'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['name']],
            [['create', 'update'], ['name']],
            ['delete', true],
        ];
    }
}