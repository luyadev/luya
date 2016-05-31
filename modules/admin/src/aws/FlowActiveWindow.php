<?php

namespace admin\aws;

/**
 * Active Window created at 31.05.2016 15:45 on LUYA Version 1.0.0-beta7-dev.
 */
class FlowActiveWindow extends \admin\ngrest\base\ActiveWindow
{
	public $module = '@admin';
	
	public $alias = 'Flow Active Window';
	
	public $icon = 'extension';
	
	/**
	 * Renders the index file of the ActiveWindow.
	 *
	 * @return string The render index file.
	 */
	public function index()
	{
		return $this->render('index', [
			'id' => $this->itemId,
		]);
	}
}