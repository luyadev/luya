<?php

namespace admin\ngrest\base;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use admin\ngrest\NgRest;
use admin\ngrest\NgRestModeInterface;
use admin\behaviors\LogBehavior;
use admin\base\GenericSearchInterface;
use yii\helpers\Json;

abstract class Model extends \yii\db\ActiveRecord implements GenericSearchInterface, NgRestModeInterface
{
    /**
     * @var string This event will be trigger after the find population of each row when ngrest loads the data from the server to edit data. (When click on edit icon)
     */
    const EVENT_AFTER_NGREST_UPDATE_FIND = 'afterNgrestUpdateFind';
    
    /**
     * @var string This event will be trigger after the find poulation of each row when ngrest load the overview list (crud).
     */
    const EVENT_AFTER_NGREST_FIND = 'afterNgrestFind';

    const EVENT_SERVICE_NGREST = 'serviceNgrest';

    const SCENARIO_RESTCREATE = 'restcreate';

    const SCENARIO_RESTUPDATE = 'restupdate';

    public $i18n = [];

    public $extraFields = [];

    protected $ngRestServiceArray = [];

    public function init()
    {
        parent::init();
        
        foreach ($this->getNgRestConfig()->getPlugins() as $field => $plugin) {
            /*
            $plugin = NgRest::createPluginObject($plugin['type']['class'], $plugin['name'], $plugin['alias'], $plugin['i18n'], $plugin['type']['args']);
            foreach ($plugin->events() as $on => $handler) {
                $this->on($on, is_string($handler) ? [$plugin, $handler] : $handler);
            }
            */
        }
     
        // attaching behaviors after init is used to prevent user how like to use `behaviors()` method do not after to
        // call the parent behaviors.
        $this->attachBehaviors([
            'LogBehavior' => [
                'class' => LogBehavior::className(),
                'api' => $this->ngRestApiEndpoint(),
            ],
        ]);

        /*
        if (count($this->i18n) > 0) {
            $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'i18nEncodeFields']);
            $this->on(self::EVENT_BEFORE_INSERT, [$this, 'i18nEncodeFields']);
            $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'i18nEncodeFields']);
            $this->on(self::EVENT_AFTER_FIND, [$this, 'i18nAfterFind']);
            $this->on(self::EVENT_AFTER_NGREST_FIND, [$this, 'i18nAfterFind']);
        }
        */
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
     * 
     */
    public static function ngRestFind()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    public function afterFind()
    {
        if ($this->getNgRestCallType()) {
            if ($this->getNgRestCallType() == 'list') {
                $this->trigger(self::EVENT_AFTER_NGREST_FIND);
            }
            if ($this->getNgRestCallType() == 'update') {
                $this->trigger(self::EVENT_AFTER_NGREST_UPDATE_FIND);
            }
        } else {
            return parent::afterFind();
        }
    }

    /*
    public function i18nAfterFind()
    {
        $langShortCode = $this->getDefaultLang('short_code');
        $languages = $this->getLanguages();
        
        foreach ($this->i18n as $field) {
            // get value for current field
            $values = $this->$field;
            
            // if its not already unserialized, decode it
            if (!is_array($this->$field) && !empty($this->$field)) {
                $values = Json::decode($this->$field);
            }
            
            // fall back for not transformed values
            if (!is_array($values)) {
                $values = (array) $values;
            }
            
            // add all not existing languages to the array (for example a language has been added after the database item has been created)
            foreach ($languages as $lang) {
                if (!array_key_exists($lang['short_code'], $values)) {
                    $values[$lang['short_code']] = '';
                }
            }
            
            // If its not an ngrest call or the ngrest call ist 'list' auto return the value for the current default language.
            if (!$this->getNgRestCallType() || $this->getNgRestCallType() == 'list') {
                $values = (array_key_exists($langShortCode, $values)) ? $values[$langShortCode] : '';
            }

            $this->$field = $values;
        }
    }

    public function i18nEncodeFields()
    {
        foreach ($this->i18n as $field) {
            // if it is notyet serialize, encode
            if (is_array($this->$field)) {
                $this->$field = Json::encode($this->$field);
            }
        }
    }
    */

    /**
     * 
     * {@inheritDoc}
     * @see \admin\base\GenericSearchInterface::genericSearchFields()
     */
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
     * 
     * {@inheritDoc}
     * @see \admin\base\GenericSearchInterface::genericSearchHiddenFields()
     */
    public function genericSearchHiddenFields()
    {
        return [];
    }
    
    /**
     * Current Ng-Rest item does not have a detail view.
     * 
     * {@inheritDoc}
     * @see \admin\base\GenericSearchInterface::genericSearchStateProvider()
     */
    public function genericSearchStateProvider()
    {
        return [
            'state' => 'default.route.detail',
            'params' => [
                'id' => 'id',
            ],
        ];
    }

    /**
     * @param string $searchQuery a search string
     * {@inheritDoc}
     * @see \admin\base\GenericSearchInterface::genericSearch()
     */
    public function genericSearch($searchQuery)
    {
        $fields = $this->genericSearchFields();
        $pk = $this->getNgRestPrimaryKey();
        
        // add pk to fields list automatically to make click able state providers
        if (!in_array($pk, $fields)) {
            $fields[] = $pk;
        }
        
        // create active query object
        $query = self::find();
        // foreach all fields from genericSearchFields metod
        foreach ($fields as $field) {
            $query->orWhere(['like', $field, $searchQuery]);
        }
        // return array based on orWhere statement
        return $query->select($fields)->all();
    }

    private $_ngrestCallType = null;
    
    public function getNgRestCallType()
    {
        if ($this->_ngrestCallType === null) {
            $this->_ngrestCallType = (!Yii::$app instanceof \yii\web\Application) ? false : Yii::$app->request->get('ngrestCallType', false);
        }

        return $this->_ngrestCallType;
    }

    private $_ngRestPrimaryKey = null;
    
    public function getNgRestPrimaryKey()
    {
        if ($this->_ngRestPrimaryKey === null) {
            $this->_ngRestPrimaryKey = $this->getTableSchema()->primaryKey[0];
        }

        return $this->_ngRestPrimaryKey;
    }

    public function addNgRestServiceData($field, $data)
    {
        $this->ngRestServiceArray[$field] = $data;
    }
    
    public function getNgrestServices()
    {
        $this->trigger(self::EVENT_SERVICE_NGREST);

        return $this->ngRestServiceArray;
    }
    
    /**
     * Define the field types for ngrest, to use `ngRestConfigDefine()`. The definition can contain properties, but does not have to.
     *
     * ```php
     * ngrestAttributeTypes()
     * {
     *     return [
     *         'firstname' => 'text',
     *         'lastname' => 'text',
     *         'description' => 'textarea',
     *         'position' => ['selectArray', [0 => 'Mr', 1 => 'Mrs']],
     *         'image_id' => 'image',
     *         'image_id_2' => ['image'], // is equal to `image_id` field.
     *         'image_id_with_no_filter' => ['image', true],
     *     ];
     * }
     * ```
     *
     * @return array
     * @since 1.0.0-beta4
     */
    public function ngrestAttributeTypes()
    {
        return [];
    }

    /**
     * Same as ngrestAttributeTypes() but used `extraField` instead of `field`
     * 
     * @return array
     * @since 1.0.0-beta6
     */
    public function ngrestExtraAttributeTypes()
    {
        return [];
    }
    
    /**
     * Inject data from the model into the config, usage exmple in ngRestConfig method context:
     * 
     * ```php
     * public function ngRestConfig($config)
     * {
     *     // ...
     *     $this->ngRestConfigDefine($config, 'list', ['firstname', 'lastname', 'image_id']);
     *     $this->ngRestConfigDefine($config, 'create', ['firstname', 'lastname', 'description', 'position', 'image_id']);
     *     $this->ngRestConfigDefine($config, 'update', ['firstname', 'lastname', 'description', 'position', 'image_id']);
     *     // ....
     *     return $config;
     * }
     * ```
     * 
     * You can also use an array defintion to handle booth types at the same time
     * 
     * ```php
     * public function ngRestConfig($config)
     * {
     *     // ...
     *     $this->ngRestConfigDefine($config, ['create', 'update'], ['firstname', 'lastname', 'description', 'position', 'image_id']);
     *     // ....
     *     return $config;
     * }
     * ```
     * 
     * @param \admin\ngrest\ConfigBuilder $config The config which the defintion should be append
     * @param string|array $assignedType This can be a string with a type or an array with multiple types
     * @param array $fields An array with fields assign to types type based on the an `ngrestAttributeTypes` defintion.
     * @throws \yii\base\InvalidConfigException
     * @since 1.0.0-beta4
     */
    public function ngRestConfigDefine(\admin\ngrest\ConfigBuilder $config, $assignedType, array $fields)
    {
        $types = $this->ngrestAttributeTypes();
        $extraTypes = $this->ngrestExtraAttributeTypes();
        
        $scenarios = $this->scenarios();
        
        $assignedType = (array) $assignedType;
        
        foreach ($assignedType as $type)
        {
            $scenario = false;
            $scenarioFields = [];
            if ($type == 'create' || $type == 'update') {
                $scenario = 'rest'.$type;
                if (!isset($scenarios[$scenario])) {
                    throw new InvalidConfigException("The scenario '$scenario' does not exists in your scenarios list, have you forgote to defined the '$scenario' in the scenarios() method?");
                } else {
                    $scenarioFields = $scenarios[$scenario];
                }
            }
            
            foreach ($fields as $field) {
                if (!isset($types[$field]) && !isset($extraTypes[$field])) {
                    throw new InvalidConfigException("The ngrest attribue '$field' does not exists in ngrestAttributeTypes() nor in ngrestExtraAttributeTypes() method.");
                }
                
                if ($scenario && !in_array($field, $scenarioFields)) {
                    throw new InvalidConfigException("The field '$field' does not exists in the scenario '$scenario'. You have to define them in the scenarios() method.");
                }
    
                if (isset($extraTypes[$field])) {
                    $typeField = 'extraField';
                    $definition = $extraTypes[$field];
                } else {
                    $typeField = 'field';
                    $definition = $types[$field];
                }
                
                $args = [];
                if (is_array($definition)) {
                    $method = $definition[0];
                    $args = array_slice($definition, 1);
                } else {
                    $method = $definition;
                }
                
                $config->$type->$typeField($field, $this->getAttributeLabel($field))->addPlugin($method, $args);
            }
        }
    }
    
    private $_config = null;
    
    /**
     * Build and call the full config object if not build yet for this model.
     * 
     * @return object|mixed
     */
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
