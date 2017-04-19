<?php

namespace luya\admin\commands;

use Yii;
use luya\console\Command;
use yii\helpers\Inflector;
use luya\admin\base\Filter;
use luya\helpers\FileHelper;

class FilterController extends Command
{
    public $identifier = null;
    
    public $name = null;
    
    public $chain = null;
    
    public function actionIndex()
    {
        if ($this->identifier === null) {
            $this->identifier = Inflector::variablize($this->prompt('Enter the filter identifier', ['required' => true]));
        }

        if ($this->name === null) {
            $this->name = ucfirst($this->prompt('Would you like to enter a Name?', ['required' => false, 'default' => ucfirst($this->identifier)]));
        }
        
        if ($this->chain === null) {
            $select = $this->select('What type of Effect?', [Filter::EFFECT_THUMBNAIL => 'Thumbnail', Filter::EFFECT_CROP => 'Crop']);
            
            if ($select == Filter::EFFECT_THUMBNAIL) {
                $dimension = $this->prompt('Dimensions (width x height)', ['required' => true, 'default' => '600xnull']);
            } else {
                $dimension = $this->prompt('Dimensions (width x height)', ['required' => true, 'default' => '600xnull']);
            }
            
            if ($select == Filter::EFFECT_THUMBNAIL) {
            	$namedSelect = 'self::EFFECT_THUMBNAIL';
            } else {
            	$namedSelect = 'self::EFFECT_CROP';
            }
            
            $xp = explode("x", $dimension);
            $this->chain[$namedSelect] = ['width' => $xp[0], 'height' => $xp[1]];
        }
        
        $folder = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'filters';
        $className = $this->name . 'Filter';
        $content = $this->generateClassView($this->identifier, $this->name, $this->chain, $className);
        $filePath = $folder . DIRECTORY_SEPARATOR . $className . '.php';
        
        if (FileHelper::createDirectory($folder) && FileHelper::writeFile($filePath, $content)) {
        	return $this->outputSuccess('Successfully generated ' . $filePath);	
        }
    }
    
    public function generateClassView($identifier, $name, array $chain, $className)
    {
    	return $this->view->render('@admin/views/commands/filter/filterClass.php', [
    		'identifier' => $identifier,
    		'name' => $name,
    		'chain' => $chain,
    		'className' => $className,
    		'luyaText' => $this->getGeneratorText('block/create'),
    	]);
    }
}