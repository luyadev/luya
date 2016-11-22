<?php

namespace luya\admin\ngrest\plugins;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\ngrest\base\Plugin;
use luya\rest\ActiveController;

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
 *         'labelFields' => ['firstname', 'lastname', 'email'],
 *         'labelTemplate' =>  '%s %s (%s)'
 *     ],
 * }
 * ```
 *
 * You can also access getter fields from the $model class in order to display such informations in the checkbox selection. Assuming you have a `getMyName` method in the
 * $model object you can use it in the `labelFields` as `myName`.
 * 
 * @property \luya\admin\ngrest\base\NgRestModel $model The model object
 * @author Basil Suter <basil@nadar.io>
 */
class CheckboxRelation extends Plugin
{
    private $_model;
    
    /**
     * @var string The reference table table name e.g. `admin_user_groupadmin_user_group`.
     */
    public $refJoinTable = null;

    /**
     * @var string The reference table model field name e.g `group_id`.
     */
    public $refModelPkId = null;

    /**
     * @var string The reference table poin field name e.g. `user_id`.
     */
    public $refJoinPkId = null;

    /**
     * @var array A list of fields which should be used for the display template.
     */
    public $labelFields = null;

    /**
     * @var string The template which is sued for the label fields like the sprinf command e.g. `%s %s (%s)`.
     */
    public $labelTemplate = null;

    /**
     * @var boolean Whether the checkbox plugin should only trigger for the restcreate and restupdate events or for all SAVE/UPDATE events.
     */
    public $onlyRestScenarios = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->addEvent(NgRestModel::EVENT_AFTER_INSERT, [$this, 'afterSaveEvent']);
        $this->addEvent(NgRestModel::EVENT_AFTER_UPDATE, [$this, 'afterSaveEvent']);
    }
    
    public function setModel($className)
    {
        $this->_model = $className;
    }

    private $_modelPrimaryKey = null;
    
    public function getModelPrimaryKey()
    {
        if ($this->_modelPrimaryKey === null) {
            $pkname = $this->model->primaryKey();
            $this->_modelPrimaryKey = reset($pkname);
        }
        
        return $this->_modelPrimaryKey;
    }
    
    public function getModel()
    {
        if (!is_object($this->_model)) {
            $this->_model = Yii::createObject(['class' => $this->_model]);
        }
        
        return $this->_model;
    }
    
    private function getOptionsData()
    {
        $items = [];

        $pk = $this->model->primaryKey();
        $pkName = $this->getModelPrimaryKey();

        $select = $this->labelFields;
        $select[] = $pkName;
        foreach ($this->model->find()->all() as $item) {
            $array = $item->getAttributes($select);
            unset($array[$pkName]);
            if ($this->labelTemplate) {
                $label = vsprintf($this->labelTemplate, $array);
            } else {
                $label = implode(', ', $array);
            }
            $items[] = ['value' => $item[$pkName], 'label' => $label];
        }

        return ['items' => $items];
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
     * @inheritdoc
     */
    public function serviceData()
    {
        return ['relationdata' => $this->getOptionsData()];
    }

    /**
     * @inheritdoc
     */
    public function onBeforeExpandFind($event)
    {
        $data = [];
        foreach ($this->model->find()->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)->where([$this->refJoinTable.'.'.$this->refModelPkId => $event->sender->id])->each() as $item) {
            $data[] = ['value' => $item->getAttribute($this->getModelPrimaryKey())];
        }
        $event->sender->{$this->name} = $data;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeListFind($event)
    {
        $event->sender->{$this->name} = $this->model->find()->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)->where([$this->refJoinTable.'.'.$this->refModelPkId => $event->sender->id])->all();
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeFind($event)
    {
        $event->sender->{$this->name} = $this->model->find()->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)->where([$this->refJoinTable.'.'.$this->refModelPkId => $event->sender->id])->all();
    }

    /**
     * @inheritdoc
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
        // @todo check if an error happends wile the delete and/or update proccess.
        return true;
    }
}
