<?php

namespace admin\ngrest\base;

use Yii;
use admin\ngrest\base\EventBehavior;
use admin\behaviors\LogBehavior;

abstract class Model extends \yii\db\ActiveRecord implements \admin\base\GenericSearchInterface
{
    /*
    public $ngRestEndpoint = null;

    public $ngRestPrimaryKey = null;
    */

    const EVENT_AFTER_NGREST_FIND = 'afterNgrestFind';
    
    const EVENT_SERVICE_NGREST = 'serviceNgrest';
    
    public $i18n = [];

    //public $i18nExpandFields = false;

    public $extraFields = [];

    public $ngRestServiceArray = [];
    
    private $_ngrestCall = false;
    
    private $_ngrestCallType = false;
    
    private $_config = null;
    
    abstract public function ngRestConfig($config);

    abstract public function ngRestApiEndpoint();

    public function init()
    {
        parent::init();

        $this->attachBehaviors([
            'EventBehavior' => [
            	'class' => EventBehavior::className(),
            	'ngRestConfig' => $this->getNgRestConfig(),
        	],
        	'LogBehavior' => [
            	'class' => LogBehavior::className(),
            	'api' => $this->ngRestApiEndpoint(),
        	]
        ]);
        
        if (Yii::$app instanceof \yii\web\Application) {
            $this->_ngrestCall = Yii::$app->request->get('ngrestCall', false);
            $this->_ngrestCallType = Yii::$app->request->get('ngrestCallType', false);
        }
        if (count($this->getI18n()) > 0) {
            $this->on(self::EVENT_BEFORE_INSERT, [$this, 'i18nBeforeUpdateAndCreate']);
            $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'i18nBeforeUpdateAndCreate']);
            $this->on(self::EVENT_AFTER_FIND, [$this, 'i18nAfterFind']);
            // @todo is there a better to know we are runing the module from the RestActiveController instead of using a get param (ugly)?
            //$this->i18nExpandFields = \yii::$app->request->get('ngrestCall', false);
        }
    }

    /**
     * @param unknown_type $value
     * @param unknown_type $viaTableName   news_article_tag
     * @param unknown_type $localTableId   article_id
     * @param unknown_type $foreignTableId tag_id
     */
    protected function proccess($value, $viaTableName, $localTableId, $foreignTableId)
    {
        throw new \Exception('use setRelation() method instead of proccess() method!');
    }

    /**
     * @param string $value          The valued which is provided from the setter method
     * @param string $viaTableName   Example viaTable name: news_article_tag
     * @param string $localTableId   The name of the field inside the viaTable which represents the match against the local table, example: article_id
     * @param string $foreignTableId The name of the field inside the viaTable which represents the match against the foreign table, example: tag_id
     *
     * @return bool
     */
    public function setRelation($value, $viaTableName, $localTableId, $foreignTableId)
    {
        $delete = \yii::$app->db->createCommand()->delete($viaTableName, [$localTableId => $this->id])->execute();
        $batch = [];
        foreach ($value as $k => $v) {
            $batch[] = [$this->id, $v['id']];
        }
        if (!empty($batch)) {
            $insert = \yii::$app->db->createCommand()->batchInsert($viaTableName, [$localTableId, $foreignTableId], $batch)->execute();
        }
        // @todo check if an error happends wile the delete and/or update proccess.
        return true;
    }

    /**
     * can be overwritte in the model class or could be directly defined as property $extraFields.
     *
     * @return array Array containing extrafields, where value is the extraField name.
     */
    public function extraFields()
    {
        return $this->extraFields;
    }

    /**
     * @TODO ATTENTION THIS IS NOT SECURE TO HIDE SENSITIVE DATA, TO HIDE SENSTIVIE DATA YOU ALWAYS HAVE TO OVERWRITE find()
     */
    public static function ngRestFind()
    {
        return static::find();
    }
    
    public function genericSearchFields()
    {
        $fields = [];
        foreach($this->getTableSchema()->columns as $name => $object) {
            if ($object->phpType == 'string') {
                $fields[] = $object->name;
            }
        }
        return $fields;
    }
    
    public function genericSearch($searchQuery)
    {
        $query = self::find();
        $fields = $this->genericSearchFields();
        foreach($fields as $field) {
            $query->orWhere(['like', $field, $searchQuery]);
        }
        return $query->select($fields)->asArray()->all();
    }
    
    public function afterFind()
    {
        if ($this->_ngrestCall && $this->_ngrestCallType == 'list') {
            $this->trigger(self::EVENT_AFTER_NGREST_FIND);
        }   
        
        return parent::afterFind();
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

            foreach ($langs as $lang) {
                if (!array_key_exists($lang->short_code, $values)) {
                    $values[$lang->short_code] = '';
                }
            }

            if (!$this->_ngrestCall) {
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

    /*
    public function ngRestApiEndpoint()
    {
        if ($this->ngRestEndpoint === null) {
            throw new \yii\base\InvalidConfigException('The "ngRestEndpoint" property must be set.');
        }

        return $this->ngRestEndpoint;
    }
    */

    public function ngRestPrimaryKey()
    {
        return $this->getTableSchema()->primaryKey[0];
    }

    public function getNgrestServices()
    {
        $this->trigger(self::EVENT_SERVICE_NGREST);
        return $this->ngRestServiceArray;
    }
    
    public function getNgRestConfig()
    {
        if ($this->_config == null) {
            $config = new \admin\ngrest\Config($this->ngRestApiEndpoint(), $this->ngRestPrimaryKey());
            
            $config->setExtraFields($this->extraFields());
            $config->i18n($this->getI18n());
            
            $this->_config = $this->ngRestConfig($config);
        }
        
        return $this->_config;
    }
}
