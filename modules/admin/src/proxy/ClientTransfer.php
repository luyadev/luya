<?php

namespace luya\admin\proxy;

use yii\base\Object;
use Curl\Curl;

class ClientTransfer extends Object
{
	/**
	 * @var \luya\admin\proxy\ClientBuild
	 */
	public $build;
	
	public function start()
	{	
		foreach ($this->build->getTables() as $name => $table) {
			/* @var $table \luya\admin\proxy\ClientTable */
			
			if (!$table->isComplet()) {
				$this->build->command->outputInfo('Rows Expected: ' . $table->getRows());
				$this->build->command->outputInfo('Rows Downloaded: ' . count($table->getContentRows()));
				return $this->build->command->outputError('Incomplet build, stop execution: ' . $name);
			}
		}
		
		foreach ($this->build->getTables() as $table) {
			/* @var $table \luya\admin\proxy\ClientTable */
			$table->syncData();
		}
		
		// close the build
		
		$curl = new Curl();
		$curl->get($this->build->requestCloseUrl, ['buildToken' => $this->build->buildToken]);
		
		return true;
	}
}