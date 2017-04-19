<?php

namespace luya\admin\commands;

use luya\console\Command;
use yii\helpers\Inflector;
use luya\admin\base\Filter;

class FilterController extends Command
{
    public $identifier = null;
    
    public $name = null;
    
    public $chain = null;
    
    public function actionIndex()
    {
        if ($this->identifier === null) {
            $this->identifier = Inflector::id2camel($this->prompt('Enter the filter identifier', ['required' => true]));
        }

        if ($this->name === null) {
            $this->name = $this->prompt('Would you like to enter a Name?', ['required' => false, 'default' => $this->identifier]);
        }
        
        if ($this->chain === null) {
            $select = $this->select('What type of Effect?', [Filter::EFFECT_THUMBNAIL => 'Thumbnail', Filter::EFFECT_CROP => 'Crop']);
            
            if ($select == Filter::EFFECT_THUMBNAIL) {
                $dimension = $this->prompt('Dimensions (width x height)', ['required' => true, 'default' => '600xnull']);
            } else {
                $dimension = $this->prompt('Dimensions (width x height)', ['required' => true, 'default' => '600xnull']);
            }
            
            $xp = explode("x", $dimension);
            $this->chain[] = [
                $select, ['width' => $xp[0], 'height' => $xp[1]],
            ];
        }
        
        
        var_dump($this->identifier, $this->name, $this->chain);
    }
}