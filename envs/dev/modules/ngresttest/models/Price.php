<?php

namespace ngresttest\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\DetailViewActiveWindow;

/**
 * Price.
 * 
 * File has been created with `crud/create` command on LUYA version 1.0.0-dev. 
 *
 * @property integer $event_id
 * @property integer $category_id
 * @property string $amount
 */
class Price extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ngresttest_price';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-ngresttest-price';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => Yii::t('app', 'Event ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'category_id', 'amount'], 'required'],
            [['event_id', 'category_id'], 'integer'],
            [['amount'], 'string', 'max' => 255],
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
        return ['amount'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'amount' => 'text',
            'event_id' => 'number',
            'category_id' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['amount']],
            [['create', 'update'], ['amount', 'event_id', 'category_id']],
            ['delete', true],
        ];
    }
}