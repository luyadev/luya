<?php

namespace cmsadmin\blockfolders;

class BaseFolder extends \BlockFolder
{
	public function identifier()
	{
		return 'default-group';
	}
	
	public function label()
	{
		return Yii::t('app', 'Basic Elements');
	}
}