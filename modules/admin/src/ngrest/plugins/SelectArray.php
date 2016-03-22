<?php

namespace admin\ngrest\plugins;

class SelectArray extends \admin\ngrest\plugins\Select
{
    public $data = [];
    
    public function init()
    {
    	parent::init();
    	
    	$cleandata = [];
    	foreach ($this->data as $key => $value) {
    		$cleandata[] = [
    			'value' => (int) $key,
    			'label' => $value,
    		];
    	}
    	
    	$this->data = $cleandata;
    }
}
