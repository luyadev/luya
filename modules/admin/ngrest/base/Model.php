<?php

namespace admin\ngrest\base;

use Yii;
use admin\behaviors\LogBehavior;
use admin\models\Lang;

abstract class Model extends \yii\db\ActiveRecord implements \admin\base\GenericSearchInterface
{
    const EVENT_AFTER_NGREST_FIND = 'afterNgrestFind';

    const EVENT_SERVICE_NGREST = 'serviceNgrest';

    private $_ngrestCallType = null;

    private $_ngRestPrimaryKey = null;

    private $_config = null;

    /**
     * Containg the default language assoc array.
     * 
     * @var array
     */
    private $_lang = null;

    /**
     * Containg all availabe languages from Lang Model.
     * 
     * @var array
     */
    private $_langs = null;

    public $i18n = [];

    public $extraFields = [];

    public $ngRestServiceArray = [];

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
            ],
        ]);

        if (count($this->i18n) > 0) {
            $this->on(self::EVENT_BEFORE_INSERT, [$this, 'i18nBeforeUpdateAndCreate']);
            $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'i18nBeforeUpdateAndCreate']);
            $this->on(self::EVENT_AFTER_FIND, [$this, 'i18nAfterFind']);
            $this->on(self::EVENT_AFTER_NGREST_FIND, [$this, 'i18nAfterFind']);
        }
    }

    /**
     * @param string $value          The valued which is provided from the setter method
     * @param string $viaTableName   Example viaTable name: news_article_tag
     * @param string $localTableId   The name of the field inside the viaTable which represents the match against the local table, example: article_id
     * @param string $foreignTableId The name of the field inside the viaTable which represents the match against the foreign table, example: tag_id
     *
     * @todo should be outside of model, move to checkboxrelation plugin ?
     *
     * @return bool
     */
    public function setRelation($value, $viaTableName, $localTableId, $foreignTableId)
    {
        $delete = Yii::$app->db->createCommand()->delete($viaTableName, [$localTableId => $this->id])->execute();
        $batch = [];
        foreach ($value as $k => $v) {
            $batch[] = [$this->id, $v['id']];
        }
        if (!empty($batch)) {
            $insert = Yii::$app->db->createCommand()->batchInsert($viaTableName, [$localTableId, $foreignTableId], $batch)->execute();
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

    /*
    public function afterFind()
    {
        if ($this->getNgRestCallType() == 'list') {
            $this->trigger(self::EVENT_AFTER_NGREST_FIND);
        }

        return parent::afterFind();
    }
    */
    
    public function afterFind()
    {
        if ($this->getNgRestCallType()) {
            $this->trigger(self::EVENT_AFTER_NGREST_FIND);
        } else {
            return parent::afterFind();
        }
    }

    private function getDefaultLang($field = false)
    {
        if ($this->_lang === null) {
            $this->_lang = Lang::findActive();
        }

        if ($field) {
            return $this->_lang[$field];
        }

        return $this->_lang;
    }

    private function getLanguages()
    {
        if ($this->_langs === null) {
            $this->_langs = Lang::getQuery();
        }

        return $this->_langs;
    }

    public function i18nAfterFind()
    {
        foreach ($this->i18n as $field) {
            $values = @json_decode($this->$field, true);
            // fall back for not transformed values
            if (!is_array($values)) {
                $values = (array) $values;
            }
            // creata all languages where doe not exists in the array
            foreach ($this->getLanguages() as $lang) {
                if (!array_key_exists($lang['short_code'], $values)) {
                    $values[$lang['short_code']] = '';
                }
            }
            // if its not an grest call automaticaly load the default language
            if (!$this->getNgRestCallType()) {
                //$langShortCode = $defaultLang['short_code'];
                $langShortCode = $this->getDefaultLang('short_code');
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
        foreach ($this->i18n as $field) {
            $this->$field = json_encode($this->$field);
        }
    }

    public function genericSearchFields()
    {
        $fields = [];
        foreach ($this->getTableSchema()->columns as $name => $object) {
            if ($object->phpType == 'string') {
                $fields[] = $object->name;
            }
        }

        return $fields;
    }

    /**
     * @param string $searchQuery a search string
     *
     * @see \admin\base\GenericSearchInterface::genericSearch()
     */
    public function genericSearch($searchQuery)
    {
        $fields = $this->genericSearchFields();
        // create active query object
        $query = self::find();
        // foreach all fields from genericSearchFields metod
        foreach ($fields as $field) {
            $query->orWhere(['like', $field, $searchQuery]);
        }
        // return array based on orWhere statement
        return $query->select($fields)->all();
    }

    public function getNgRestCallType()
    {
        if ($this->_ngrestCallType === null) {
            $this->_ngrestCallType = (!Yii::$app instanceof \yii\web\Application) ? false : Yii::$app->request->get('ngrestCallType', false);
        }

        return $this->_ngrestCallType;
    }

    public function getNgRestPrimaryKey()
    {
        if ($this->_ngRestPrimaryKey === null) {
            $this->_ngRestPrimaryKey = $this->getTableSchema()->primaryKey[0];
        }

        return $this->_ngRestPrimaryKey;
    }

    public function getNgrestServices()
    {
        $this->trigger(self::EVENT_SERVICE_NGREST);

        return $this->ngRestServiceArray;
    }

    public function getNgRestConfig()
    {
        if ($this->_config == null) {
            $config = Yii::createObject(['class' => '\admin\ngrest\Config', 'apiEndpoint' => $this->ngRestApiEndpoint(), 'primaryKey' => $this->getNgRestPrimaryKey()]);
            $configBuilder = new \admin\ngrest\ConfigBuilder();
            $this->ngRestConfig($configBuilder);
            $config->setConfig($configBuilder->getConfig());
            foreach ($this->i18n as $fieldName) {
                $config->appendFieldOption($fieldName, 'i18n', true);
            }
            $this->_config = $config;
        }

        return $this->_config;
    }
}
