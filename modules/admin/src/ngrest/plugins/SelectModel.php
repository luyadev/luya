<?php

namespace luya\admin\ngrest\plugins;
;
use yii\db\ActiveRecordInterface;
use luya\helpers\ArrayHelper;

/**
 * DropDown Select
 * 
 * Create a selection dropdown based on an ActiveRecord Model.
 *
 * Example usage:
 *
 * ```php
 * public function ngRestAttributeTypes()
 * {
 *     return [
 *         'genres' => ['selectModel', 'modelClass' => path\to\Genres::className(), 'valueField' => 'id', 'labelField' => 'title'],
 *     ];
 * }
 * ```
 *
 * If there is no valueField value provided the primary key from the `modelClass` will be returned automatically. The label data will automatically sorted by the label in ASC direction.
 *
 * The labelField can also provided as callable method:
 *
 * ```php
 * 'labelField' => function($model) {
 *     return $model->firstname . ' ' . $model->lastname;
 * }
 * ```
 * 
 * You can also use the quick mode which finds the primary key by itself, therfore just keep valueField empty.
 *
 * @property string $valueField The field name which should represent the value of the data array. This value will be stored in the database and is mostly the primary key of the $modelClass Model.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class SelectModel extends Select
{
    /**
     * @var string The className of the ActiveRecord or NgRestModel in order to build the ActiveQuery find methods.
     */
    public $modelClass;
    
    /**
     * @var string|array|callable An array or string to select the data from, this data will be returned in the select overview.
     *
     * An example of how to use multiple labels.
     *
     * ```php
     * 'labelField' => ['lastname', 'firstname'], // generate a label with lastname firstname
     * ```
     *
     * In order to use callables the first param is the model:
     *
     * ```php
     * 'labelField' => function($model) {
     *     return $model->firstname . ' ' . $model->lastname;
     * }
     * ```
     */
    public $labelField;
    
    /**
     * @var boolean|string If enabled you can defined how the placed variables should be strucutred. For example in combination with array labels:
     *
     * An example of how to use the template with multiple fields:
     *
     * ```php
     * 'labelField' => ['firstname', 'lastname', 'email'],
     * 'labelTemplate' => '%s %s (%s%)',
     * ```
     *
     * The above example woudl print `John Doe (john@example.com)`.
     */
    public $labelTemplate = false;
 
    /**
     * @var boolean|array An array with where conditions to provide for the active query. The value will be used like this in the conditions:
     *
     * ```php
     * $data = $modelClass::find()->where($where)->all();
     * ```
     *
     * Assuming `$where` has the value `['is_deleted' => 0]` the query would look as below:
     *
     * ```php
     * $data = $modelClass::find()->where(['is_deleted' => 0])->all();
     * ```
     */
    public $where = false;
    
    private static $_dataInstance = [];

    /**
     * Data DI Container for relation data.
     *
     * @param string $class
     * @param string|array $where
     * @return mixed
     */
    private static function getDataInstance($class, $where)
    {
        if (!isset(static::$_dataInstance[$class])) {
            $query = $class::find();
            if ($where !== false) {
                $query->where($where);
            }
            $queryData = $query->all();
            static::$_dataInstance[$class] = $queryData;
        }
        
        return static::$_dataInstance[$class];
    }
    
    /**
     * Flush Instances
     */
    private static function flushDataInstances()
    {
        static::$_dataInstance = [];
    }
    
    /**
     * 
     * @param ActiveRecordInterface $model
     * @return mixed|unknown
     */
    private function generateLabelField(ActiveRecordInterface $model)
    {
        if (is_callable($this->labelField, false)) {
            return call_user_func($this->labelField, $model);
        }
        
        $defintion = (array) $this->labelField;
        
        $values = [];
        foreach ($defintion as $field) {
            $data = $model->$field;
            
            if (is_array($data)) {
                $data = reset($data);
            }
            
            $values[] = $data;
        }
         
        if ($this->labelTemplate) {
            return vsprintf($this->labelTemplate, $values);
        }
        
        return implode(" ", $values);
    }
    
    private $_valueField;
    
    /**
     * Getter Method for valueField.
     * 
     * If no value is provided it will auto matically return the primary key of the derived model class.
     * 
     * @return string The primary key from `modelClass`.
     */
    public function getValueField()
    {
    	if ($this->_valueField === null) {
    		$class = $this->modelClass;
    		$this->_valueField = implode("", $class::primaryKey());
    	}
    	
    	return $this->_valueField;
    }
    
    /**
     * Setter method for valueField.
     *
     * @param string $value The field name which should represent the value of the data array. This value will be stored in the database and is mostly the primary key
     * of the $modelClass Model.
     */
    public function setValueField($value)
    {
    	$this->_valueField = $value;
    }
    
    /**
     * @inheritdoc
     */
    public function getData()
    {
        $data = [];
        
        $class = $this->modelClass;
        
        if (is_object($class)) {
            $class = $class::className();
        }
        
        foreach (static::getDataInstance($class, $this->where) as $item) {
            
            $data[] = [
                'value' => (int) $item->{$this->valueField},
                'label' => $this->generateLabelField($item),
            ];
        }
        
        ArrayHelper::multisort($data, 'label');
        
        return $data;
    }
    
    public function renderCreate($id, $ngModel)
    {
        return [
            $this->createCrudLoaderTag($this->modelClass),
            $this->createFormTag('zaa-select', $id, $ngModel, ['initvalue' => $this->initValue, 'options' => $this->getServiceName('selectdata')]),
        ];
    }
    
    public function __destruct()
    {
        self::flushDataInstances();
    }
}
