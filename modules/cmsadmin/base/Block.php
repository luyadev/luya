<?php

namespace cmsadmin\base;

use Yii;
use yii\helpers\Inflector;
use luya\helpers\Url;
use admin\storage\ImageQuery;
use admin\storage\FileQuery;

/**
 * Base class for all CMS Blocks.
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
     * @var bool Enable or disable the block caching
     */
    public $cacheEnabled = false;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;
    
    /**
     * @var bool Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     *           in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = false;

    /**
     * @var string Containing the name of the environment (used to find the view files to render). The
     *             module(Name) can be started with the Yii::getAlias() prefix `@`, otherwhise the `@` will be 
     *             added automatically.
     */
    public $module = 'app';

    /**
     * @var array Define a list of assets to be insert in the frontend context. The assets will be ignored in
     *            admin context. Example usage of assets property:
     * 
     * ```php
     * public $assets = [
     *     'app\assets\MyAjaxBlockAsset',
     * ];
     * ```
     */
    public $assets = [];

    /**
     * Return link for usage in ajax request, the link will call the defined callback inside
     * this block. All callback methods must start with `callback`. An example for a callback method:.
     * 
     * ```php
     * public function callbackTestAjax($arg1)
     * {
     *     return 'hello callback test ajax with argument: arg1 ' . $arg1;
     * }
     * ```
     * 
     * The above defined callback link can be created with the follow code:
     * 
     * ```php
     * $this->createAjaxLink('TestAjax', ['arg1' => 'My Value for Arg1']);
     * ```
     * 
     * The most convient way to assign the variable is via extraVars
     * 
     * ```php
     * public function extraVars()
     * {
     *     return [
     *         'ajaxLinkToTestAjax' => $this->createAjaxLink('TestAjax', ['arg1' => 'Value for Arg1']),
     *     ];
     * }
     * ```
     * 
     * @param string $callbackName The callback name in uppercamelcase to call. The method must exists in the block class.
     * @param array  $params       A list of parameters who have to match the argument list in the method.
     *
     * @return string
     */
    public function createAjaxLink($callbackName, array $params = [])
    {
        $params['callback'] = Inflector::camel2id($callbackName);
        $params['id'] = $this->getEnvOption('id', 0);

        return Url::toAjax('cms/block/index', $params);
    }

    public function icon()
    {
        return;
    }

    /**
     * Returns true if block is active in backend.
     *
     * @return bool
     */
    public function isAdminContext()
    {
        return ($this->getEnvOption('context', false) === 'admin') ? true : false;
    }

    /**
     * Returns true if block is active in frontend.
     *
     * @return bool
     */
    public function isFrontendContext()
    {
        return ($this->getEnvOption('context', false) === 'frontend') ? true : false;
    }

    /**
     * Sets a key => value pair in env options.
     *
     * @param string $key   The string to be set as key
     * @param mixed  $value The value that will be stored associated with the given key
     */
    public function setEnvOption($key, $value)
    {
        $this->_envOptions[$key] = $value;
    }

    /**
     * Get a env option by $key. If $key does not exist it will return given $default or false.
     *
     * @param $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getEnvOption($key, $default = false)
    {
        return (array_key_exists($key, $this->_envOptions)) ? $this->_envOptions[$key] : $default;
    }

    /**
     * Returns all environment/context informations where the block have been placed. Example Data.
     *
     * + id (unique identifier for the block in cms context)
     * + blockId (id in the block list database, which is not unique)
     * + context
     * + pageObject
     *
     * @return array Returns an array with key value parings.
     */
    public function getEnvOptions()
    {
        return $this->_envOptions;
    }

    /**
     * Sets placeholder values.
     *
     * @param array $placeholders The array to be set as placeholder values
     */
    public function setPlaceholderValues(array $placeholders)
    {
        $this->_placeholderValues = $placeholders;
    }

    /**
     * User method to get the values inside the class.
     *
     * @param string $key     The name of the key you want to retrieve
     * @param mixed  $default A default value that will be returned if the key isn't found
     *
     * @return mixed
     */
    public function getVarValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_varValues)) ? $this->_varValues[$key] : $default;
    }

    /**
     * Sets var values.
     *
     * @param array $values The array to be set as var values
     */
    public function setVarValues(array $values)
    {
        $this->_varValues = $values;
    }

    /**
     * User method to get the cfgs inside the block.
     * 
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getCfgValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_cfgValues)) ? $this->_cfgValues[$key] : $default;
    }

    /**
     * Sets the config values.
     *
     * @param array $values The array to be set as config values
     */
    public function setCfgValues(array $values)
    {
        $this->_cfgValues = $values;
    }

    /**
     * Returns the name of the twig file to be rendered.
     *
     * @return string The name of the twig file (example.twig)
     */
    public function getRenderFileName()
    {
        $classname = get_class($this);

        if (preg_match('/\\\\([\w]+)$/', $classname, $matches)) {
            $classname = $matches[1];
        }

        return $classname.'.twig';
    }

    /**
     * Returns the content of the frontend twig file.
     *
     * @return string Twig frontend file content
     *
     * @throws \Exception If the twig file doesn't exist
     */
    public function getTwigFrontendContent()
    {
        $twigFile = $this->getTwigRenderFile('@app');
        if (file_exists($twigFile)) {
            return $this->baseRender('@app');
        }

        return $this->twigFrontend();
    }

    // access from outside

    /**
     * @return array
     */
    public function extraVars()
    {
        return [];
    }
    
    /**
     * Returns an array with additional help informations for specific field (var or cfg).
     *
     * @return array An array where the key is the cfg/var field var name and the value the helper text.
     */
    public function getFieldHelp()
    {
        return [];
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function getPlaceholders()
    {
        return (array_key_exists('placeholders', $this->config())) ? $this->config()['placeholders'] : [];
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function getFullName()
    {
        return ($this->icon() === null) ? $this->name() : '<i class="material-icons">'.$this->icon().'</i> <span>'.$this->name().'</span>';
    }

    /**
     * @param \Twig_Environment $twig
     *
     * @return string
     */
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

    /**
     * @param $app
     *
     * @return bool|string
     */
    protected function getTwigRenderFile($app)
    {
        return Yii::getAlias($app.'/views/blocks/'.$this->getRenderFileName());
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    protected function render()
    {
        $moduleName = $this->module;
        if (substr($moduleName, 0, 1) !== '@') {
            $moduleName = '@'.$moduleName;
        }

        return $this->baseRender($moduleName);
    }

    /**
     * @param $module
     *
     * @return string
     *
     * @throws \Exception
     */
    private function baseRender($module)
    {
        $twigFile = $this->getTwigRenderFile($module);
        if (!file_exists($twigFile)) {
            throw new \Exception("Twig file '$twigFile' does not exists!");
        }

        return file_get_contents($twigFile);
    }
    
    /**
     * Get all informations from an zaa-image-upload type:
     * 
     * ```php
     * 'image' => $this->zaaImageUpload($this->getVarValue('myImage')),
     * ```
     * 
     * apply a filter for the image
     * 
     * ```php
     * 'imageFiltered' => $this->zaaImageUpload($this->getVarValue('myImage', 'small-thumbnail'),
     * ```
     * 
     * @param string|int $value Provided the value
     * @param boolean|string $applyFilter To apply a filter insert the identifier of the filter.
     * @return boolean|array Returns false when not found, returns an array with all data for the image on success.
     */
    protected function zaaImageUpload($value, $applyFilter = false)
    {
        if (empty($value)) {
            return false;
        }
        
        $image = (new ImageQuery())->findOne($value);
        
        if (!$image) {
            return false;
        }
        
        if ($applyFilter && is_string($applyFilter)) {
            $filter = $image->applyFilter($applyFilter);
            
            if ($filter) {
                return $filter->toArray();
            }
        }
        
        return $image->toArray();
    }
    
    /**
     * Return all informations for a file if exists
     * 
     * ```php
     * 'file' => $this->zaaFileUpload($this->getVarValue('myFile')),
     * ```
     * 
     * @param string|int $value Provided the value
     * @return boolean|array Returns false when not found, returns an array with all data for the image on success.
     */
    protected function zaaFileUpload($value)
    {
        if (!empty($value)) {
            $file = (new FileQuery())->findOne($value);
            
            if ($file) {
                return $file->toArray();
            }
        }
        
        return false;
    }
    
    /**
     * Get the full array for the specific zaa-file-array-upload type
     * 
     * ```php
     * 'fileList' => $this->zaaFileArrayUpload('files'),
     * ```
     * 
     * Each array item will have all file query item data and a caption key.
     * 
     * @param string|int $value The specific var or cfg fieldvalue.
     * @return array Returns an array in any case, even an empty array.
     */
    protected function zaaFileArrayUpload($value)
    {
        if (!empty($value) && is_array($value)) {
            $data = [];
            
            foreach($value as $key => $item) {
                $file = $this->zaaFileUpload($item['fileId']);
                if ($file) {
                    $file['caption'] = $item['caption'];
                    $data[$key] = $file;
                }
            }
            
            return $data;
        }
        
        return [];
    }

    /**
     * Get the full array for the specific zaa-file-image-upload type
     * 
     * ```php
     * 'imageList' => $this->zaaImageArrayUpload('images'),
     * ```
     * 
     * Each array item will have all file query item data and a caption key.
     * 
     * @param string|int $value The specific var or cfg fieldvalue.
     * @param boolean|string $applyFilter To apply a filter insert the identifier of the filter.
     * @return array Returns an array in any case, even an empty array.
     */
    protected function zaaImageArrayUpload($value, $applyFilter = false)
    {
        if (!empty($value) && is_array($value)) {
            $data = [];
            
            foreach($value as $key => $item) {
                $image = $this->zaaImageUpload($item['imageId'], $applyFilter);
                if ($image) {
                    $image['caption'] = $item['caption'];
                    $data[$key] = $image;
                }
            }
            
            return $data;
        }
        
        return [];
    }
}
