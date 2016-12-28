<?php

namespace luya\admin\proxy;

use Yii;
use yii\base\Object;

/**
 * @since 1.0.0
 * @var \yii\db\TableSchema $schema Schema object
 */
class ClientFile extends Object
{
	/**
	 * @var \luya\admin\proxy\ClientBuild
	 */
	public $build = null;

	public function __construct(ClientBuild $build, array $config = [])
	{
		$this->build = $build;
		parent::__construct($config);
	}
}