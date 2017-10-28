<?php

namespace luya\admin\models;

use yii\helpers\Json;
use Imagine\Image\ManipulatorInterface;
use yii\base\InvalidConfigException;
use yii\imagine\Image;
use yii\db\ActiveRecord;

/**
 * Contains all information about filter effects for a single Chain element (like: thumbnail, 200x200).
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class StorageFilterChain extends ActiveRecord
{
    private $comperator = [
        'crop' => [
            'required' => ['width', 'height'],
            'options' => ['start' => [0, 0], 'saveOptions' => []],
        ],
        'thumbnail' => [
            'required' => ['width', 'height'],
            'options' => ['mode' => ManipulatorInterface::THUMBNAIL_OUTBOUND, 'saveOptions' => []]
        ],
        'watermark' => [
            
        ],
        'text' => [
            
        ],
        'frame' => [
            
        ]
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_storage_filter_chain';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'eventBeforeValidate']);
        $this->on(self::EVENT_AFTER_FIND, [$this, 'eventAfterFind']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filter_id', 'effect_id'], 'required'],
            [['effect_json_values'], 'safe'],
        ];
    }

    public function eventBeforeValidate()
    {
        if (is_array($this->effect_json_values)) {
            $this->effect_json_values = Json::encode($this->effect_json_values);
        }
    }

    public function eventAfterFind()
    {
        $this->effect_json_values = Json::decode($this->effect_json_values);
    }

    public function getEffect()
    {
        return $this->hasOne(StorageEffect::className(), ['id' => 'effect_id']);
    }
    
    protected function getJsonValue($key)
    {
        return (array_key_exists($key, $this->effect_json_values)) ? $this->effect_json_values[$key] : false;
    }
    
    public function applyFilter($loadFromPath, $imageSavePath)
    {
        if (!$this->evalMethod()) {
            throw new InvalidConfigException('The requested effect mode ' . $this->effect->imagine_name . ' is not supported');
        }
        
        if (!$this->evalRequiredMethodParams()) {
            throw new InvalidConfigException("The requested effect mode does require some parameters which are not provided.");
        }
        
        switch ($this->effect->imagine_name) {
            case "crop":
                $image = Image::crop($loadFromPath, $this->getMethodParam('width'), $this->getMethodParam('height'));
                Image::autoRotate($image)->save($imageSavePath, $this->getMethodParam('saveOptions'));
                break;
            case "thumbnail":
                $image = Image::thumbnail($loadFromPath, $this->getMethodParam('width'), $this->getMethodParam('height'), $this->getMethodParam('mode'));
                Image::autoRotate($image)->save($imageSavePath, $this->getMethodParam('saveOptions'));
                break;
        }
    }

    protected function evalMethod()
    {
        return (isset($this->comperator[$this->effect->imagine_name])) ? $this->comperator[$this->effect->imagine_name] : false;
    }
    
    protected function evalRequiredMethodParams()
    {
        foreach ($this->evalMethod()['required'] as $param) {
            if ($this->getJsonValue($param) === false) {
                return false;
            }
        }
        
        return true;
    }
    
    protected function getMethodParam($name)
    {
        $value = $this->getJsonValue($name);
        
        if ($value === false) {
            if (isset($this->evalMethod()['options'][$name])) {
                return $this->evalMethod()['options'][$name];
            }
        }
        
        return $value;
    }
}
