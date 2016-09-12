<?php

namespace luya\admin\models;

/**
 * This is the model class for table "admin_config".
 *
 * @property string $name
 * @property string $value
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name'], 'unique'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
    
    /**
     * Check whether a config value exists or not
     *
     * @param string $name
     * @return boolean
     */
    public static function has($name)
    {
        return (self::find()->where(['name' => $name])->one()) ? true : false;
    }

    /**
     * Get the value of a config value
     *
     * @param string $name
     * @return string|null
     */
    public static function get($name)
    {
        $model = self::find()->where(['name' => $name])->asArray()->one();

        if ($model) {
            return $model['value'];
        }

        return null;
    }

    /**
     * Store or Update an existing/new config value.
     *
     * @param string $name
     * @param string $value
     */
    public static function set($name, $value)
    {
        $model = self::find()->where(['name' => $name])->one();

        if ($model) {
            return (bool) $model->updateAttributes([
                'value' => $value,
            ]);
        }

        $model = new self();
        $model->value = $value;
        $model->name = $name;
        return $model->save();
    }

    /**
     * Remove an existing config value
     *
     * @param string $name
     */
    public static function remove($name)
    {
        $model = self::find()->where(['name' => $name])->one();
        
        if ($model) {
            return (bool) $model->delete();
        }

        return false;
    }
}
