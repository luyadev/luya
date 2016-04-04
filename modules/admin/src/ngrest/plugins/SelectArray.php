<?php

namespace admin\ngrest\plugins;

/**
 * Create a selection based on an assoc array provided via $data attribute.
 * 
 * Example usage:
 * 
 * ```
 * public function ngrestAttributeTypes()
 * {
 * 		'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
 * }
 * ```
 * 
 * @author nadar
 */
class SelectArray extends \admin\ngrest\plugins\Select
{
    public $data = [];
    
    public function init()
    {
    	parent::init();
    	
    	$cleandata = [
    	    ['value' => 0,'label' => \admin\Module::t('ngrest_select_no_selection')],
    	    ['value' => null, 'label' => "- - - - - - - - - - - - - - - -"],
    	];
    	
    	foreach ($this->data as $key => $value) {
    		$cleandata[] = [
    			'value' => (int) $key,
    			'label' => $value,
    		];
    	}
    	
    	$this->data = $cleandata;
    }
}
