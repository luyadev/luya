<?php

namespace luya\admin\ngrest\base;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use luya\admin\behaviors\LogBehavior;
use luya\admin\base\GenericSearchInterface;
use luya\admin\ngrest\Config;
use luya\admin\ngrest\ConfigBuilder;
use luya\admin\base\RestActiveController;

/**
 * NgRest Model.
 *
 * Read the Guide to understand [[ngrest-concept.md]].
 *
 * This class extends the {{yii\db\ActiveRecord}}.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class NgRestModel extends ActiveRecord implements GenericSearchInterface, NgRestModelInterface
{
    /**
     * @var string This event will be trigger after the find population of each row when ngrest loads the data from the server to edit data. (When click on edit icon)
     */
    const EVENT_AFTER_NGREST_UPDATE_FIND = 'afterNgrestUpdateFind';
    
    /**
     * @var string This event will be trigger after the find poulation of each row when ngrest load the overview list (crud).
     */
    const EVENT_AFTER_NGREST_FIND = 'afterNgrestFind';

    /**
     * @var string This event will be trigger when findin the service data of a plugin
     */
    const EVENT_SERVICE_NGREST = 'serviceNgrest';

    /**
     * @var array Defines all fields which should be casted as i18n fields. This will transform the defined fields into
     * json language content parings and the plugins will threat the fields different when saving/updating or request
     * informations.
     *
     * ```php
     * public $i18n = ['textField', 'anotherTextField', 'imageField']);
     * ```
     */
    public $i18n = [];

    protected $ngRestServiceArray = [];
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'NgRestEventBehvaior' => [
                'class' => NgRestEventBehavior::className(),
                'plugins' => $this->getNgRestConfig()->getPlugins(),
            ],
            'LogBehavior' => [
                'class' => LogBehavior::className(),
                'api' => static::ngRestApiEndpoint(),
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[RestActiveController::SCENARIO_RESTCREATE] = $scenarios[self::SCENARIO_DEFAULT];
        $scenarios[RestActiveController::SCENARIO_RESTUPDATE] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return array_keys($this->ngRestExtraAttributeTypes());
    }
    
    /**
     * Whether a field is i18n or not.
     *
     * @param string $fieldName The name of the field which is
     * @return boolean
     */
    public function isI18n($fieldName)
    {
        return in_array($fieldName, $this->i18n) ? true : false;
    }

    /**
     * Define an array with filters you can select from the crud list.
     *
     * ```php
     * return [
     *     'deleted' => self::find()->where(['is_deleted' => 0]),
     *     'year2016' => self::find()->where(['between', 'date', 2015, 2016]),
     * ];
     * ```
     *
     * @return array Return an array where key is the name and value is the find() condition for the filters.
     * @since 1.0.0
     */
    public function ngRestFilters()
    {
        return [];
    }

    /**
     * Define the default ordering for the ngrest list when loading, by default the primary key
     * sorted ascending is used. To override the method for example sorting by a timestamp field:
     *
     * ```php
     * public function ngRestListOrder()
     * {
     *     return ['created_at' => SORT_ASC];
     * }
     * ```
     *
     * If the return value is `false` the sorting **is disabled** for this NgRest CRUD.
     *
     * @return array Return an Array where the key is the field and value the direction. Example `['timestamp' => SORT_ASC]`.
     * @since 1.0.0
     */
    public function ngRestListOrder()
    {
        return [$this->getNgRestPrimaryKey()[0] => SORT_DESC];
    }
    
    /**
     * Grouping fields into fieldset similar group names which can be collapsed by default or not:
     *
     * ```php
     * public function ngRestAttributeGroups()
     * {
     *    return [
     *       [['timestamp_create', 'timestamp_display_from', 'timestamp_display_until'], 'Timestamps', 'collapsed' => true],
     *       [['image_list', 'file_list'], 'Images', 'collapsed' => false],
     *    ];
     * }
     * ```
     *
     * If collapsed is `true` then the form group is hidden when opening the form, otherwhise its open by default (which is default value when not provided).
     *
     * @return array An array with groups where offset 1 are the fields, 2 the name of the group `collapsed` key if default collapsed or not.
     * @since 1.0.0
     */
    public function ngRestAttributeGroups()
    {
        return [];
    }
    
    /**
     * Enable the Grouping by a field option by default. Allows you to predefine the default group field.
     *
     * ```php
     * public function ngRestGroupByField()
     * {
     *     return 'cat_id';
     * }
     * ```
     *
     * Now by default the fields are grouped by the cat_id field, the admin user can always reset the group by filter
     * to none.
     *
     * @return string The field of what the default grouping should be, false disables the default grouping (default).
     * @since 1.0.0
     */
    public function ngRestGroupByField()
    {
        return false;
    }
    
    /**
     * Define your relations in order to access the relation data and manage them directly in the same view.
     *
     * Example of how to use two relation buttons based on models which as to be ngrest model as well with apis!
     *
     * ```php
     * public function ngRestRelations()
     * {
     * 	   return [
     *          ['label' => 'The Label', 'apiEndpoint' => \path\to\ngRest\Model::ngRestApiEndpoint(), 'dataProvider' => $this->getSales()],
     *     ];
     * }
     * ```
     *
     * The above example will use the `getSales()` method of the current model where you are implementing this relation. The `getSales()` must return
     * an {{yii\db\QueryInterface}} Object, for example you can use `$this->hasMany(Model, ['key' => 'rel'])` or `new \yii\db\Query()`.
     *
     * You can also define the `tabLabelAttribute` key with the name of a field you like the display as tab name. Assuming your table as a column `title` you
     * can set `'tabLabelAttribute'  => 'title'` in order to display this value in the tab label.
     *
     * @return array
     */
    public function ngRestRelations()
    {
        return [];
    }
    
    /**
     * The NgRestFind is used when performing the crud list index overivew. You
     * can override this method in order to hide data from the ngRestFind command
     * which populates all data from the database.
     *
     * An example for hidding deleted news posts from the curd list:
     *
     * ```php
     * public static function ngRestFind()
     * {
     *     return parent::ngRestFind()->where(['is_deleted' => 0]);
     * }
     * ```
     *
     * + see [[yii\db\ActiveRecord::find()]]
     *
     * @return yii\db\ActiveQuery
     */
    public static function ngRestFind()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * Search trough the whole table as ajax fallback when pagination is enabled.
     *
     * This method is used when the angular crud view switches to a pages view and a search term is entered into
     * the query field. It differs to the generic search as it takes more performence to lookup all fields (except
     * of boolean types).
     *
     * When you have relations to lookup you can extend the parent implementation, for example:
     *
     * ```php
     * public function ngRestFullQuerySearch($query)
     * {
     *	return parent::ngRestFullQuerySearch($query)
     *		->joinWith(['production'])
     *		->orFilterWhere(['like', 'title', $query]);
     * }
     * ```
     *
     * @param string $query The query which will be used in order to make the like statement request.
     * @return \yii\db\ActiveQuery Returns an ActiveQuery instance in order to send to the ActiveDataProvider.
     */
    public function ngRestFullQuerySearch($query)
    {
        $find = $this->ngRestFind();
        
        foreach ($this->getTableSchema()->columns as $column) {
            if ($column->phpType !== "boolean") {
                $find->orFilterWhere(['like', static::tableName() . '.' . $column->name, $query]);
            }
        }
        
        return $find;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function genericSearchHiddenFields()
    {
        return [];
    }
    
    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function genericSearch($searchQuery)
    {
        $fields = $this->genericSearchFields();
        
        foreach ($this->getNgRestPrimaryKey() as $pk) {
            // add pk to fields list automatically to make click able state providers
            if (!in_array($pk, $fields)) {
                $fields[] = $pk;
            }
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

    private $_ngrestCallType;
    
    /**
     * Determine the current call type based on get params as they can change the output behavior to make the ngrest crud list view.
     *
     * @return boolean|string
     */
    public function getNgRestCallType()
    {
        if ($this->_ngrestCallType === null) {
            $this->_ngrestCallType = (!Yii::$app instanceof \yii\web\Application) ? false : Yii::$app->request->get('ngrestCallType', false);
        }

        return $this->_ngrestCallType;
    }
    
    /**
     * Whether the current model is in api context (REST SCENARIOS or CALL TYPE) context or not.
     *
     * @return boolean Whether the current model is in api context or not.
     */
    public function getIsNgRestContext()
    {
        if ($this->scenario == RestActiveController::SCENARIO_RESTCREATE
            || $this->scenario == RestActiveController::SCENARIO_RESTUPDATE
            || $this->getNgRestCallType()) {
            return true;
        }
        
        return false;
    }

    private $_ngRestPrimaryKey;

    /**
     * Getter method for NgRest Primary Key.
     * @return string
     * @throws InvalidConfigException
     */
    public function getNgRestPrimaryKey()
    {
        if ($this->_ngRestPrimaryKey === null) {
            $keys = static::primaryKey();
            if (!isset($keys[0])) {
                throw new InvalidConfigException("The NgRestModel '".__CLASS__."' requires at least one primaryKey in order to work.");
            }
            
            return $keys;
        }

        return $this->_ngRestPrimaryKey;
    }

    /**
     * Setter method for NgRest Primary Key
     *
     * @param string $key
     */
    public function setNgRestPrimaryKey($key)
    {
        $this->_ngRestPrimaryKey = $key;
    }
    
    /**
     *
     * @param string $field
     * @param mixed $data
     */
    public function addNgRestServiceData($field, $data)
    {
        $this->ngRestServiceArray[$field] = $data;
    }
    
    /**
     * Triggers the event service event and returns the resolved data.
     *
     * @return mixed The service data.
     */
    public function getNgRestServices()
    {
        $this->trigger(self::EVENT_SERVICE_NGREST);

        return $this->ngRestServiceArray;
    }
    
    /**
     * Define the field types for ngrest, to use `ngRestConfigDefine()`.
     *
     * The definition can contain properties, but does not have to.
     *
     * ```php
     * public function ngRestAttributeTypes()
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
     * @since 1.0.0-RC1
     */
    public function ngRestAttributeTypes()
    {
        return [];
    }

    /**
     * Same as ngRestAttributeTypes() but used for extraField instead of field.
     *
     * @see ngRestAttributeTypes()
     * @return array
     * @since 1.0.0-RC2
     */
    public function ngRestExtraAttributeTypes()
    {
        return [];
    }

    /**
     * Defines the scope which field should be used for what situation.
     *
     * ```php
     * public function ngRestScopes()
     * {
     *     return [
     *         ['list', ['firstname', 'lastname']],
     *         [['create', 'update'], ['firstname', 'lastname', 'description', 'image_id']],
     *         ['delete', true],
     *     ]:
     * }
     * ```
     *
     * The create and update scopes can also be written in seperated notation in order to configure
     * different forms for create and update:
     *
     * ```php
     * public function ngRestScopes()
     * {
     *     return [
     *         ['list', ['firstname', 'lastname']],
     *         ['create', ['firstname', 'lastname', 'description', 'image_id']],
     *         ['update', ['description']],
     *     ];
     * }
     * ```
     */
    public function ngRestScopes()
    {
        return [];
    }
    
    /**
     * Define Active Window configurations.
     *
     * ```php
     * public function ngRestActiveWindows()
     * {
     *     return [
     *         ['class' => 'luya\admin\aws\TagActiveWindow', 'label' => 'Tags Label'],
     *         ['class' => luya\admin\aws\ChangePasswordActiveWindow::class, 'label' => 'Change your Password'],
     *     ];
     * }
     * ```
     */
    public function ngRestActiveWindows()
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
     * @param \luya\admin\ngrest\ConfigBuilder $config The config which the defintion should be append
     * @param string|array $assignedType This can be a string with a type or an array with multiple types
     * @param array $fields An array with fields assign to types type based on the an `ngRestAttributeTypes` defintion.
     * @throws \yii\base\InvalidConfigException
     * @since 1.0.0
     */
    public function ngRestConfigDefine(ConfigBuilder $config, $assignedType, array $fields)
    {
        $types = $this->ngRestAttributeTypes();
        $extraTypes = $this->ngRestExtraAttributeTypes();
        
        $scenarios = $this->scenarios();
        
        $assignedType = (array) $assignedType;
        
        foreach ($assignedType as $type) {
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
                    throw new InvalidConfigException("The ngrest attribue '$field' does not exists in ngRestAttributeTypes() nor in ngRestExtraAttributeTypes() method.");
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
                    if (array_key_exists('class', $definition)) {
                        $method = $definition['class'];
                        unset($definition['class']);
                        $args = $definition;
                    } else {
                        $method = $config->prepandAdminPlugin($definition[0]);
                        $args = array_slice($definition, 1);
                    }
                } else {
                    $method = $config->prepandAdminPlugin($definition);
                }
                
                $config->$type->$typeField($field, $this->getAttributeLabel($field))->addPlugin($method, $args);
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        foreach ($this->ngRestScopes() as $arrayConfig) {
            if (!isset($arrayConfig[0]) && !isset($arrayConfig[1])) {
                throw new InvalidConfigException("Invalid ngRestScope defintion. Definition must contain an array with two elements: `['create', []]`");
            }
            
            $scope = $arrayConfig[0];
            $fields = $arrayConfig[1];

            if ($scope == 'delete' || (is_array($scope) && in_array('delete', $scope))) {
                $config->delete = $fields;
            } else {
                $this->ngRestConfigDefine($config, $scope, $fields);
            }
        }
        
        foreach ($this->ngRestActiveWindows() as $windowConfig) {
            $config->aw->load($windowConfig);
        }
    }
    
    private $_config;
    
    /**
     * Build and call the full config object if not build yet for this model.
     *
     * @return \luya\admin\ngrest\Config
     */
    public function getNgRestConfig()
    {
        if ($this->_config == null) {
            $config = new Config();
            
            // Generate config builder object
            $configBuilder = new ConfigBuilder(static::class);
            $this->ngRestConfig($configBuilder);
            $config->setConfig($configBuilder->getConfig());
            foreach ($this->i18n as $fieldName) {
                $config->appendFieldOption($fieldName, 'i18n', true);
            }

            // copy model data into config
            $config->setApiEndpoint(static::ngRestApiEndpoint());
            $config->setPrimaryKey($this->getNgRestPrimaryKey());
            $config->setFilters($this->ngRestFilters());
            $config->setDefaultOrder($this->ngRestListOrder());
            $config->setAttributeGroups($this->ngRestAttributeGroups());
            $config->setGroupByField($this->ngRestGroupByField());
            $config->setTableName($this->tableName());
            $config->setAttributeLabels($this->attributeLabels());
            
            // ensure relations are made not on composite table.
            if ($this->ngRestRelations() && count($this->getNgRestPrimaryKey()) > 1) {
                throw new InvalidConfigException("You can not use the ngRestRelations() on composite key model.");
            }
            
            // generate relations
            foreach ($this->ngRestRelations() as $key => $item) {
                /** @var $item \luya\admin\ngrest\base\NgRestRelationInterface */
                if (!$item instanceof NgRestRelation) {
                    if (!isset($item['class'])) {
                        $item['class'] = 'luya\admin\ngrest\base\NgRestRelation';
                    }
                    $item = Yii::createObject($item);
                }
                $item->setModelClass($this->className());
                $item->setArrayIndex($key);
                $config->setRelation($item);
            }
            
            $this->_config = $config;
        }

        return $this->_config;
    }
}
