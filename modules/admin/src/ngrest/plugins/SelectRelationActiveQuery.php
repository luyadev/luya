<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;
use yii\db\ActiveQuery;

/**
 * Performance Optimised Select Releation Plugin.
 * 
 * This plugin is for CRUD tables with large amount of tables, there for you can not access the the ActiveRecord object.
 * 
 * ```php
 * 'parent_user_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getParentUser(), 'labelField' => 'firstname,lastname'],
 * 'client_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getClient(), 'labelField' => ['client_number', 'firstname', 'lastname']],
 * ```
 * 
 * @property string|array $labelField Provide the sql fields to display.
 * @property yii\db\ActiveQuery $query The query with the relation.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class SelectRelationActiveQuery extends Plugin
{
	/**
	 * @var string This value will be displayed in the ngrest list overview if the given value is empty().
	 */
	public $emptyListValue = "-";
	
	private $_labelField;
	
	/**
	 * 
	 * @param unknown $labelField
	 */
	public function setLabelField($labelField)
	{
		if (is_string($labelField)) {
			$labelField = explode(",", $labelField);
		}
		
		$this->_labelField = $labelField;
	}
	
	/**
	 * 
	 * @return unknown|array
	 */
	public function getLabelField()
	{
		return $this->_labelField;
	}

	/**
	 * @var \yii\db\ActiveQuery
	 */
	private $_query;
	
	/**
	 * 
	 * @param ActiveQuery $query
	 */
	public function setQuery(ActiveQuery $query)
	{
		$this->_query = $query;
	}
	
	/**
	 * 
	 * @return \yii\db\ActiveQuery
	 */
	public function getQuery()
	{
		return $this->_query;
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
			$this->createCrudLoaderTag($this->_query->modelClass, $ngModel),
			$this->createFormTag('zaa-span', $id, $ngModel)
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
	public function onListFind($event)
	{
		$value = $event->sender->getAttribute($this->name);
		
		if ($this->emptyListValue && empty($value)) {
			$event->sender->setAttribute($this->name, $this->emptyListValue);
		} else {
			$model = $this->_query->modelClass;
			$row = $model::find()->select($this->labelField)->where(['id' => $value])->asArray(true)->one();
			
			if (!empty($row)) {
				$event->sender->setAttribute($this->name, implode(" " , $row));
			}
		}
	}
}