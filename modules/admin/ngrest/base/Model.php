<?php

namespace admin\ngrest\base;

abstract class Model extends \yii\db\ActiveRecord
{
    public $ngRestEndpoint = null;

    public $ngRestPrimaryKey = null;

    public $i18n = [];

    public $i18nExpandFields = false;
    
    abstract public function ngRestConfig($config);

    public function init()
    {
        parent::init();

        if (count($this->getI18n()) > 0) {
            $this->on(self::EVENT_BEFORE_INSERT, [$this, 'i18nBeforeUpdateAndCreate']);
            $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'i18nBeforeUpdateAndCreate']);
            $this->on(self::EVENT_AFTER_FIND, [$this, 'i18nAfterFind']);
            // @todo is there a better to know we are runing the module from the RestActiveController instead of using a get param (ugly)?
            $this->i18nExpandFields = \yii::$app->request->get('ngrestExpandI18n', false);
        }
    }

    public function i18nAfterFind()
    {
        foreach ($this->getI18n() as $field) {
            $values = @json_decode($this->$field, true);
            // fall back for not transformed values
            if (!is_array($values)) {
                $values = (array) $values;
            }
            
            $langs = \admin\models\Lang::find()->all();
            
            foreach ($langs as $lang)
            {
                if (!array_key_exists($lang->short_code, $values)) {
                    $values[$lang->short_code] = '';
                }
            }
            
            if (!$this->i18nExpandFields) {
                $langShortCode = \admin\models\Lang::getDefault()->short_code;
                
                // @todo first get data from collection, if not found get data from lang default
                if (array_key_exists($langShortCode, $values)) {
                    $values = $values[$langShortCode];
                } else {
                    $values = '';
                }
                
            }
            
            $this->$field = $values;
        }
        
    }

    public function i18nBeforeUpdateAndCreate()
    {
        foreach ($this->getI18n() as $field) {
            $this->$field = json_encode($this->$field);
        }
    }
    
    public function getI18n()
    {
        return $this->i18n;
    }

    public function getNgRestApiEndpoint()
    {
        if ($this->ngRestEndpoint === null) {
            throw new \yii\base\InvalidConfigException('The "ngRestEndpoint" property must be set.');
        }
        return $this->ngRestEndpoint;
    }

    public function getNgRestPrimaryKey()
    {
        if (!empty($this->ngRestPrimaryKey)) {
            return $this->ngRestPrimaryKey;
        }

        return $this->getTableSchema()->primaryKey[0];
    }

    public function getNgRestConfig()
    {
        $config = new \admin\ngrest\Config($this->getNgRestApiEndpoint(), $this->getNgRestPrimaryKey());

        $config->i18n($this->getI18n());

        return $this->ngRestConfig($config);
    }
}
