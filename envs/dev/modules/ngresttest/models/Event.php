<?php

namespace ngresttest\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Event.
 * 
 * File has been created with `crud/create` command on LUYA version 1.0.0-dev. 
 *
 * @property integer $id
 * @property string $name
 */
class Event extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ngresttest_event';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-ngresttest-event';
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
            ['delete', false],
        ];
    }
}