<?php

namespace luya\admin\ngrest\plugins;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\ngrest\base\Plugin;
use luya\rest\ActiveController;
use luya\helpers\ArrayHelper;
use luya\admin\helpers\I18n;

/**
 * Checkbox Selector via relation table.
 *
 * The checkbox relation plugin provides an easy way to provde a checkbox selection from a via relation table.
 *
 * In order to implement the checkboxRealtion plugin you have to prepare your {{\luya\admin\ngrest\base\NgRestModel}} as following:
 *
 * ```php
 * public $groups = [];
 *
 * public function extraFields()
 * {
 *     return ['groups'];
 * }
 * ```
 *
 * Configure the extra field with {{\luya\admin\ngrest\base\NgRestModel::ngRestExtraAttributeTypes}}:
 *
 * ```php
 * public function ngRestExtraAttributeTypes()
 * {
 *     'groups' => [
 *         'checkboxRelation',
 *         'model' => User::className(),
 *         'refJoinTable' => 'admin_user_group',
 *         'refModelPkId' => 'group_id',
 *         'refJoinPkId' => 'user_id',
 *         'labelField' => ['firstname', 'lastname', 'email'],
 *         'labelTemplate' =>  '%s %s (%s)'
 *     ],
 * }
 * ```
 *
 * You can also access getter fields from the $model class in order to display such informations in the checkbox selection. Assuming you have a `getMyName` method in the
 * $model object you can use it in the `labelField` as `myName`.
 *
 * In order to use a function for the labelField:
 *
 * ```php
 * 'labelField' => function($model) {
 *     return $model->firstname . ' ' . $model->lastname;
 * }
 * ```
 *
 * In case you want to get an active query item for the checkboxRelation data you can add a relation getter method which will be used to collect to data.
 *
 * ```php
 * public function getGroups()
 * {
 *     return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('admin_user_grou', ['group_id' => 'id']);
 * }
 * ```
 *
 * As now the there is a relation for `groups` this relation query will be used in order to return the data.
 *
 * @property \luya\admin\ngrest\base\NgRestModel $model The model object
 * @property string $modelPrimaryKey The primary key string.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CheckboxRelation extends Plugin
{
    /**
     * @var string The reference table table name e.g. `admin_user_groupadmin_user_group`.
     */
    public $refJoinTable;

    /**
     * @var string The reference table model field name e.g `group_id`.
     */
    public $refModelPkId;

    /**
     * @var string The reference table poin field name e.g. `user_id`.
     */
    public $refJoinPkId;

    /**
     * @var array A list of fields which should be used for the display template. Can also be a callable function to build the field with the template
     *
     * ```php
     * 'labelField' => function($array) {
     *     return $array['firstname'] . ' ' . $array['lastname'];
     * }
     * ```
     */
    public $labelField;

    /**
     * @var string The template which is sued for the label fields like the sprinf command e.g. `%s %s (%s)`.
     */
    public $labelTemplate;

    /**
     * @var boolean Whether the checkbox plugin should only trigger for the restcreate and restupdate events or for all SAVE/UPDATE events.
     */
    public $onlyRestScenarios = false;

    /**
     * @var boolean Whether the admin request should be retrived as admin or not, by default its an admin query as this is more performat but
     * you only have an array within the labelField closure.
     */
    public $asArray = true;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->addEvent(NgRestModel::EVENT_AFTER_INSERT, [$this, 'afterSaveEvent']);
        $this->addEvent(NgRestModel::EVENT_AFTER_UPDATE, [$this, 'afterSaveEvent']);
    }
    
    private $_modelPrimaryKey;
    
    public function getModelPrimaryKey()
    {
        if ($this->_modelPrimaryKey === null) {
            $pkname = $this->model->primaryKey();
            $this->_modelPrimaryKey = reset($pkname);
        }
    
        return $this->_modelPrimaryKey;
    }
    
    private $_model;
    
    /**
     * Setter method for the model.
     *
     * @param string $className
     */
    public function setModel($className)
    {
        $this->_model = $className;
    }

    /**
     * Getter method for model.
     *
     * @return \yii\base\Model
     */
    public function getModel()
    {
        if (!is_object($this->_model)) {
            $this->_model = Yii::createObject(['class' => $this->_model]);
        }
        
        return $this->_model;
    }
    
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return [
            $this->createCrudLoaderTag($this->model->className()),
            $this->createFormTag('zaa-checkbox-array', $id, $ngModel, ['options' => $this->getServiceName('relationdata')]),
        ];
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }

    /**
     * Get the options data to display.
     *
     * @return array
     */
    private function getOptionsData($event)
    {
        $items = [];
        
        foreach ($this->model->find()->asArray($this->asArray)->all() as $item) {
            if (is_callable($this->labelField, false)) {
                $label = call_user_func($this->labelField, $item);
            } else {
                if ($this->labelField === null) {
                    $this->labelField = array_keys($item);
                }
                $array = ArrayHelper::filter($item, $this->labelField);
                
                foreach ($array as $key => $value) {
                    if ($event->sender->isI18n($key)) {
                        $array[$key] = I18n::decodeActive($value);
                    }
                }
                
                $label = $this->labelTemplate ? vsprintf($this->labelTemplate, $array) : implode(', ', $array);
            }
        
            $items[] = ['value' => (int) $item[$this->modelPrimaryKey], 'label' => $label];
        }
        
        return ['items' => $items];
    }
    
    /**
     * @inheritdoc
     */
    public function serviceData($event)
    {
        return ['relationdata' => $this->getOptionsData($event)];
    }

    /**
     * @inheritdoc
     */
    public function onBeforeExpandFind($event)
    {
        $data = [];
        foreach ($this->model->find()
            ->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)
            ->where([$this->refJoinTable.'.'.$this->refModelPkId => $event->sender->id])
            ->asArray(true)
            ->each() as $item) {
            $data[] = ['value' => $item[$this->getModelPrimaryKey()]];
        }
        $event->sender->{$this->name} = $data;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeFind($event)
    {
        $event->sender->{$this->name} = $this->getRelationData($event);
    }
    
    private function getRelationData($event)
    {
        $relation = $event->sender->getRelation($this->name, false);
        if ($relation) {
            return $relation;
        }
        
        return $this->model->find()->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)->where([$this->refJoinTable.'.'.$this->refModelPkId => $event->sender->id])->all();
    }

    /**
     * Tiggers after Save/Update methods.
     *
     * ```php
     * $this->addEvent(NgRestModel::EVENT_AFTER_INSERT, [$this, 'afterSaveEvent']);
     * $this->addEvent(NgRestModel::EVENT_AFTER_UPDATE, [$this, 'afterSaveEvent']);
     * ```
     *
     * @param \yii\base\Event $event An ActiveRecord  event.
     */
    public function afterSaveEvent($event)
    {
        if ($this->onlyRestScenarios) {
            if ($event->sender->scenario == ActiveController::SCENARIO_RESTCREATE || $event->sender->scenario == ActiveController::SCENARIO_RESTUPDATE) {
                $this->setRelation($event->sender->{$this->name}, $this->refJoinTable, $this->refModelPkId, $this->refJoinPkId, $event->sender->id);
            }
        } else {
            $this->setRelation($event->sender->{$this->name}, $this->refJoinTable, $this->refModelPkId, $this->refJoinPkId, $event->sender->id);
        }
    }
    
    /**
     * Set the relation data based on the configuration.
     *
     * @param array $value The valued which is provided from the setter method
     * @param string $viaTableName Example viaTable name: news_article_tag
     * @param string $localTableId The name of the field inside the viaTable which represents the match against the local table, example: article_id
     * @param string $foreignTableId The name of the field inside the viaTable which represents the match against the foreign table, example: tag_id
     * @return boolean Whether updating the database was successfull or not.
     */
    protected function setRelation(array $value, $viaTableName, $localTableId, $foreignTableId, $activeRecordId)
    {
        Yii::$app->db->createCommand()->delete($viaTableName, [$localTableId => $activeRecordId])->execute();
        $batch = [];
        foreach ($value as $k => $v) {
            // $this->id: the value of the current database model, example when relation ins on user model id would be user id
            // $v['id'] extra field values foreached from the join table, so id will represent the joined table pk.

            // issue #696 array logic
            if (is_array($v)) { // its an array and is based on the logic of the angular checkbox releation ['id' => 123] // new: 'value' => 123 since beta6
                if (isset($v['value'])) {
                    $batch[] = [$activeRecordId, $v['value']];
                }
            } else { // its not an array so it could have been assigned from the frontend
                $batch[] = [$activeRecordId, $v];
            }
        }
        if (!empty($batch)) {
            Yii::$app->db->createCommand()->batchInsert($viaTableName, [$localTableId, $foreignTableId], $batch)->execute();
        }
        return true;
    }
}
