<?php

namespace luya\admin\ngrest\validators;

use Yii;
use yii\validators\Validator;
use luya\admin\helpers\Storage;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\base\Model;
use luya\base\DynamicModel;
use luya\admin\ngrest\base\NgRestModelInterface;
use yii\base\InvalidConfigException;

/**
 * Storage Upload Validator.
 *
 * Storing Files into the storage system in order to View them inside the NgRest Context.
 *
 * ### Single File Upload
 *
 * Model rule:
 *
 * ```php
 * [['attachment'], StorageUploadValidator::class],
 * ```
 *
 * View File:
 *
 * ```php
 * <?= $form->field($model, 'attachment')->fileInput(['accept' => 'file/*']) ?>
 * ```
 *
 * ### Multiple Files Upload
 *
 * Mode rule:
 *
 * ```php
 * [['attachments'], StorageUploadValidator::class, 'multiple' => true],
 * ```
 *
 * View File:
 *
 * ```php
 * <?= $form->field($model, 'attachments[]')->fileInput(['multiple' => true, 'accept' => 'file/*']) ?>
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class StorageUploadValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public $skipOnEmpty = false;
    
    /**
     * @var boolean Whether its possible to upload multiple files or just a single file
     */
    public $multiple = false;
    
    /**
     * @var integer The folder id where all files will be uploaded to, this is the virtual directory number from {{luya\admin\componenets\StorageContainer}}. Defaults
     * is 0 which is the root directory of the file manager. If {{isHidden}} is enabled, the folder id does not matter as its not shown in the file manager anyhow.
     */
    public $folderId = 0;
    
    /**
     * @var boolean Whether the files should be visible inside the file manager or not.
     */
    public $isHidden = true;
    
    /**
     *
     * {@inheritDoc}
     * @see \yii\validators\Validator::validateAttribute()
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$model instanceof NgRestModelInterface) {
            throw new InvalidConfigException("The model must be an instance of NgRestModelInterface.");
        }
        
        if ($model->getIsNgRestContext()) {
            return;
        }
        
        $files = $this->multiple ? UploadedFile::getInstances($model, $attribute) : (array) UploadedFile::getInstance($model, $attribute);
        
        $contextModel = new DynamicModel(['file' => $files]);
        $contextModel->addRule(['file'], 'file', ['maxFiles' => $this->multiple ? 0 : 1])->validate();
        
        if ($contextModel->hasErrors()) {
            return $this->addError($model, $attribute, $contextModel->getFirstError('file'));
        }
         
        $data = [];
        foreach ($files as $file) {
            $name = $file->baseName . '.' . $file->extension;
            $save = Yii::$app->storage->addFile($file->tempName, $name, $this->folderId, $this->isHidden);
            if ($save) {
                if (!$this->multiple) {
                    // its not multiple file upload, so pick the first file and set the fileId value into the model attribute in order to store the data
                    return $model->$attribute = $save->id;
                }
                $data[] = ['fileId' => $save->id, 'caption' => null, 'hiddenStorageUploadSource' => $save->getLinkAbsolute(), 'hiddenStorageUploadName' => $save->getName()];
            } else {
                return $this->addError($model, $attribute, 'Unable to save given file.');
            }
        }
        
        // set the json value for this field which is compatible with the ngrest plugin fileArray
        $model->$attribute = Json::encode($data);
    }
}
