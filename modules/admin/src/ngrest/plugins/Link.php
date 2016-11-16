<?php

namespace luya\admin\ngrest\plugins;

Yii;
use luya\admin\ngrest\base\Plugin;

class Link extends Plugin
{
	public function renderList($id, $ngModel)
	{
		return $this->createListTag($ngModel);
	}
	
	public function renderCreate($id, $ngModel)
	{
		return $this->createFormTag('zaa-link', $id, $ngModel);
	}
	
	public function renderUpdate($id, $ngModel)
	{
		return $this->createFormTag('zaa-link', $id, $ngModel);
	}
	
	/**
	 * @inheritdoc
	 */
	public function onBeforeSave($event)
	{
		// if its not i18n casted field we have to serialize the the file array as json and abort further event excution.
		if (!$this->i18n) {
			$event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
			return false;
		}
	
		return true;
	}
	
	/**
	 * @inheritdoc
	 */
	public function onBeforeExpandFind($event)
	{
		if (!$this->i18n) {
			$event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
			return false;
		}
		 
		return true;
	}
	
	/**
	 * @inheritdoc
	 */
	public function onBeforeFind($event)
	{
		if (!$this->i18n) {
			$event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
			$event->sender->setAttribute($this->name, $this->generateLinkObject($event->sender->getAttribute($this->name)));
			return false;
		}
	
		return true;
	}
	
	public function onAfterFind($event)
	{
		$event->sender->setAttribute($this->name, $this->generateLinkObject($event->sender->getAttribute($this->name)));
	}

	protected function generateLinkObject($value)
	{
		$config = is_array($value) ? $value : [];
		
		switch ($config['type']) {
			case 1:
				return Yii::$app->menu->findOne(['id' => $config['value']])->link;
			case 2:
				return $config['value'];
		}
	}
}