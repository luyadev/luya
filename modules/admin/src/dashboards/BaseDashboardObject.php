<?php

namespace luya\admin\dashboards;

use luya\admin\base\DashboardObjectInterface;
use yii\base\Object;

abstract class BaseDashboardObject extends Object implements DashboardObjectInterface
{
	private $_template;
	
	public function setTemplate($template)
	{
		$this->_template = $template;
	}
	
	public function getTemplate()
	{
		return $this->_template;	
	}
	
	private $_dataApiUrl;
	
	public function setDataApiUrl($dataApiUrl)
	{
		$this->_dataApiUrl = $dataApiUrl;
	}
		
	public function getDataApiUrl()
	{
		return $this->_dataApiUrl;
	}
}