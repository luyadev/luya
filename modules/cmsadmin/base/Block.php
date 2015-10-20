<?php

namespace cmsadmin\base;

use Yii;
use yii\helpers\Inflector;
use luya\helpers\Url;

/**
 * Base class for all CMS Blocks
 *
 * @author nadar
 */
abstract class Block extends \yii\base\Object implements BlockInterface
{
    private $_varValues = [];

    private $_cfgValues = [];

    private $_placeholderValues = [];

    private $_envOptions = [];

    /**
     * @var string Containing the name of the environment (used to find the view files to render). The
     * module(Name) can be started with the Yii::getAlias() prefix `@`, otherwhise the `@` will be 
     * added automatically.
     */
    public $module = 'app';

    public function call($callbackName, array $args = [])
    {
        $action = 'callback'.Inflector::id2camel($callbackName);
        
        return call_user_func_array([$this, $action], $args);
    }
    
    public function createAjaxLink($callbackName, array $params = [])
    {
        $params['callback'] = Inflector::camel2id($callbackName);
        $params['blockId'] = $this->getEnvOption('blockId', 0);
        return Url::toAjax('cms/block/default', $params);   
    }
    
    public function icon()
    {
        return;
    }
    
    public function isAdminContext()
    {
        return ($this->getEnvOption('context', false) === 'admin') ? true : false;
    }

    public function isFrontendContext()
    {
        return ($this->getEnvOption('context', false) === 'frontend') ? true : false;
    }

    public function setEnvOption($key, $value)
    {
        $this->_envOptions[$key] = $value;
    }

    public function getEnvOption($key, $default = false)
    {
        return (array_key_exists($key, $this->_envOptions)) ? $this->_envOptions[$key] : $default;
    }

    /**
     * Returns all environment/context informations where the block have been placed. Example Data
     *
     * + blockId
     * + context
     * + pageObject
     *
     * @return array Returns an array with key value parings.
     */
    public function getEnvOptions()
    {
        return $this->_envOptions;
    }
    
    public function setPlaceholderValues(array $placeholders)
    {
        $this->_placeholderValues = $placeholders;
    }

    /**
     * User method to get the values inside the class
     * 
     * @param unknown $key
     * @param string $default
     * @return Ambigous <string, multitype:>
     */
    public function getVarValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_varValues)) ? $this->_varValues[$key] : $default;
    }

    public function setVarValues(array $values)
    {
        $this->_varValues = $values;
    }

    /**
     * User method to get the cfgs inside the block
     * 
     * @param unknown $key
     * @param string $default
     * @return Ambigous <string, multitype:>
     */
    public function getCfgValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_cfgValues)) ? $this->_cfgValues[$key] : $default;
    }

    public function setCfgValues(array $values)
    {
        $this->_cfgValues = $values;
    }

    public function getRenderFileName()
    {
        $classname = get_class($this);

        if (preg_match('/\\\\([\w]+)$/', $classname, $matches)) {
            $classname = $matches[1];
        }

        return $classname.'.twig';
    }

    public function getTwigFrontendContent()
    {
        $twigFile = $this->getTwigRenderFile('@app');
        if (file_exists($twigFile)) {
            return $this->baseRender('@app');
        }

        return $this->twigFrontend();
    }

    // access from outside

    public function extraVars()
    {
        return [];
    }

    public function getVars()
    {
        $config = $this->config();
        if (!array_key_exists('vars', $config)) {
            return [];
        }
        $data = [];
        foreach ($config['vars'] as $item) {
            $data[] = (new BlockVar($item))->toArray();
        }

        return $data;
    }

    public function getPlaceholders()
    {
        return (array_key_exists('placeholders', $this->config())) ? $this->config()['placeholders'] : [];
    }

    public function getCfgs()
    {
        $config = $this->config();
        if (!array_key_exists('cfgs', $config)) {
            return [];
        }
        $data = [];
        foreach ($config['cfgs'] as $item) {
            $data[] = (new BlockCfg($item))->toArray();
        }

        return $data;
    }

    public function getFullName()
    {
        return ($this->icon() === null) ? $this->name() : '<i class="left '.$this->icon().'"></i> <span>'.$this->name().'</span>';
    }

    public function renderFrontend(\Twig_Environment $twig)
    {
        return $twig->render($this->getTwigFrontendContent(), [
            'vars' => $this->_varValues,
            'cfgs' => $this->_cfgValues,
            'placeholders' => $this->_placeholderValues,
            'extras' => $this->extraVars(),
        ]);
    }
    
    /* protected and privates */
    
    protected function getTwigRenderFile($app)
    {
        return Yii::getAlias($app.'/views/blocks/'.$this->getRenderFileName());
    }
    
    protected function render()
    {
        $moduleName = $this->module;
        if (substr($moduleName, 0, 1) !== '@') {
            $moduleName = '@'.$moduleName;
        }
        return $this->baseRender($moduleName);
    }
    
    private function baseRender($module)
    {
        $twigFile = $this->getTwigRenderFile($module);
        if (!file_exists($twigFile)) {
            throw new \Exception("Twig file '$twigFile' does not exists!");
        }
    
        return file_get_contents($twigFile);
    }
}
