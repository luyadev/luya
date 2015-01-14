<?php
namespace admin\models;

use Yii;

/**
 * This is the model class for table "admin_group".
 *
 * @property integer $group_id
 * @property string $name
 * @property string $text
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['name'], 'required'],
                [['text'], 'string'],
                [['name'], 'string', 'max' => 255]
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'text'],
            'restupdate' => ['name', 'text']
        ];
    }
}
