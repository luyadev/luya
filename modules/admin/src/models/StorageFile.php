<?php

namespace luya\admin\models;

use Yii;
use luya\web\Application;
use yii\db\ActiveRecord;
use luya\helpers\FileHelper;

/**
 * This is the model class for table "admin_storage_file".
 *
 * @property integer $id
 * @property boolean $is_hidden
 * @property integer $folder_id
 * @property string $name_original
 * @property string $name_new
 * @property string $name_new_compound
 * @property string $mime_type
 * @property string $extension
 * @property string $hash_file
 * @property string $hash_name
 * @property integer $upload_timestamp
 * @property integer $file_size
 * @property integer $upload_user_id
 * @property integer $is_deleted
 * @property integer $passthrough_file
 * @property string $passthrough_file_password
 * @property integer $passthrough_file_stats
 * @property string $caption
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class StorageFile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'onBeforeInsert']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_storage_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_original', 'name_new', 'mime_type', 'name_new_compound', 'extension', 'hash_file', 'hash_name'], 'required'],
            [['folder_id', 'upload_timestamp', 'file_size', 'upload_user_id', 'upload_timestamp', 'is_deleted'], 'safe'],
            [['is_hidden'], 'boolean'],
            [['caption'], 'string'],
        ];
    }
    
    public function delete()
    {
        $file = Yii::$app->storage->getFile($this->id);
        
        if ($file) {
            if (!Yii::$app->storage->fileSystemDeleteFile($file->serverSource)) {
                Logger::error("Unable to remove storage file: " . $file->serverSource);
            }
        }
        $this->is_deleted = true;
        $this->update(false);
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->orderBy(['name_original' => 'ASC']);
    }

    public function onBeforeInsert()
    {
        $this->upload_timestamp = time();
        if (empty($this->upload_user_id)) {
            if (Yii::$app instanceof Application && !Yii::$app->adminuser->isGuest) {
                $this->upload_user_id = Yii::$app->adminuser->getId();
            }
        }
    }
}
