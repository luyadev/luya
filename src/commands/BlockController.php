<?php

namespace luya\commands;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;

class BlockController extends \luya\base\Command
{
    private function getModuleProposal()
    {
        $modules = [];
        foreach(Yii::$app->getApplicationModules() as $id => $obj) {
            $modules[$id] = $id;
        }
        return $modules;
    }
    
    private function getVariableTypes()
    {
        return [
            'text' => 'Textinput',
            'textarea' => 'Textarea multi rows input',
            'password' => 'Passwort input field (hides the signs)',
            'number' => 'Numbers allowed only',
            'wysiwyg' => 'What you see is what you get Editor',
            'select' => 'Dropdown Select',
            'date' => 'Date Selector',
            'datetime' => 'Date and Time selector',
            'checkbox' => 'A single Checkbox',
            'checkbox-array' => 'radio BUttons with several inputs',
            'file-upload' => 'User can upload a single file',
            'file-array-upload' => 'User can upload severals files',
            'image-upload' => 'creata a image upload form and return the imageId on success',
            'image-array-upload' => 'creates an asrray with image id an caption string',
            'list-array' => 'Creates an array with a key variable value',
            'table' => 'User can dynamic create tables (jsons)',
        ];
    }
    
    private function getVariableTypesOptions()
    {
        return [
            'select' => "[['value' => 1, 'label' => 'Value 1']]", // 'options' => [['value' => 1, 'label' => 'Value 1']]
            'checkbox-array' => "['items' => [['id' => 1, 'label' => 'Label for Value 1']]]", // 'options' => ['items' => [['id' => 1, 'label' => 'Label for Value 1']]]
        ];
    }
    
    private function getVariableTypeOption($type)
    {
        $types = $this->getVariableTypesOptions();
        
        return $types[$type];
    }
    
    private function hasVariableTypeOption($type)
    {
        return array_key_exists($type, $this->getVariableTypesOptions());
    }
    
    public function actionCreate()
    {
        $type = $this->select("Do you want to create an app or module Block?", [
            'app' => 'Creates a project block inside your @app Namespace (casual).', 'module' => 'Creating a block inside a later specified Module.'
        ]);
        
        $module = false;
        
        /*
        if ($type == 'module' && count($this->getModuleProposal()) === 0) {
            return $this->outputError("Your project does not have Project-Modules registered!");
        }
        */
        
        if ($type == 'module') {
            $module = $this->select("Choose a module to create the block inside:", $this->getModuleProposal());
        }
        
        $blockName = $this->prompt("Insert a name for your Block (e.g. HeadTeaser):", ['required' => true]);
        
        if (substr(strtolower($blockName), -5) !== 'block') {
            $blockName = $blockName.'Block';
        }
        
        $blockName = Inflector::camelize($blockName);
        
        $phpdoc = [];
        
        // vars
        
        $knowsTheVars = $this->confirm("Do you know the vars you want to create?", false);
        $varsAmount = 0;
        $vars = [];
        
        if ($knowsTheVars) {
            $varsAmount = $this->prompt("How many User-Input-Variables (vars) do you need?", [
                'required' => true,
                'pattern' => '/\d/',
            ]);
        }
        
        for($i = 1; $i <= $varsAmount; $i++) {
            $v = $this->varCreator($i);
            $phpdoc[] = '{{vars.'.$v['var'].'}}';
            $vars[] = $v;
        }
        
        // cfgs

        $knowsTheCfgs = $this->confirm("Do you know the cfgs you want to create?", false);
        $cfgsAmount = 0;
        $cfgs = [];
        
        if ($knowsTheCfgs) {
            $cfgsAmount = $this->prompt("How many User-Input-Configs (cfgs) do you need?", [
                'required' => true,
                'pattern' => '/\d/',
            ]);
        }

        for($i = 1; $i <= $cfgsAmount; $i++) {
            $v = $this->varCreator($i);
            $phpdoc[] = '{{cfgs.'.$v['var'].'}}';
            $cfgs[] = $v;
        }
        
        if ($module) {
            $moduleObject = Yii::$app->getModule($module);
            $basePath = $moduleObject->basePath;
            $ns = $moduleObject->getNamespace();
        } else {
            $basePath = Yii::$app->basePath;
            $ns = 'app';
        }
        
        $ns = $ns . '\\blocks';
        
        $content = '<?php'.PHP_EOL.PHP_EOL;
        $content .= 'namespace '.$ns.';'.PHP_EOL.PHP_EOL;
        $content .= 'class '.$blockName.' extends \cmsadmin\base\Block'.PHP_EOL;
        $content .= '{'.PHP_EOL;
        
        if ($module) {
            $content.= PHP_EOL.'    public $module = \''.$module.'\';'.PHP_EOL.PHP_EOL;
        }
        
        // method name
        $content .= '    public function name()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return \''.Inflector::humanize($blockName).'\';'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;
        
        // method icon
        $content .= '    public function icon()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return \'\'; // choose icon from: http://web.archive.org/web/20150315064340/http://materializecss.com/icons.html'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;
        
        $content .= '    public function config()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return ['.PHP_EOL;
        // get vars
        if (count($vars)) {
        $content .= '           \'vars\' => ['.PHP_EOL;
            foreach($vars as $k => $v) {
        $content .= '               [\'var\' => \''.$v['var'].'\', \'label\' => \''.$v['label'].'\', \'type\' => \''.$v['type'].'\'';
            if (isset($v['options'])) {
                $content.=', \'options\' => '.$v['options'];
            }
        $content .= '],'.PHP_EOL;
            }
        $content .= '           ],'.PHP_EOL;
        }
        // get cfgs
        if (count($cfgs)) {
            $content .= '           \'cfgs\' => ['.PHP_EOL;
            foreach($cfgs as $k => $v) {
                $content .= '               [\'var\' => \''.$v['var'].'\', \'label\' => \''.$v['label'].'\', \'type\' => \''.$v['type'].'\'';
                if (isset($v['options'])) {
                    $content.=', \'options\' => '.$v['options'];
                }
                $content .= '],'.PHP_EOL;
            }
            $content .= '           ],'.PHP_EOL;
        }
        $content .= '        ];'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;
        
        // method extraVars
        $content .= '    /**'.PHP_EOL;
        $content .= '     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.'.PHP_EOL;
        $content .= '     */'.PHP_EOL;
        $content .= '    public function extraVars()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return ['.PHP_EOL;
        $content .= '            // add your custom extra vars here'.PHP_EOL;
        $content .= '        ];'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;
        
        // method twigFrontend
        $content .= '    /**'.PHP_EOL;
        $content .= '     * Available twig variables:'.PHP_EOL;
        foreach($phpdoc as $doc) {
        $content .= '     * @param ' . $doc . PHP_EOL;
        }
        $content .= '     */'.PHP_EOL;
        $content .= '    public function twigFrontend()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return \'<p>My Frontend Twig of this Block</p>\';'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;
        
        // method twigAdmin
        $content .= '    /**'.PHP_EOL;
        $content .= '     * Available twig variables:'.PHP_EOL;
        foreach($phpdoc as $doc) {
        $content .= '     * @param ' . $doc . PHP_EOL;
        }
        $content .= '     */'.PHP_EOL;
        $content .= '    public function twigAdmin()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return \'<p>My Admin Twig of this Block</p>\';'.PHP_EOL;
        $content .= '    }'.PHP_EOL;
        
        $content .= '}'.PHP_EOL;
        
        $dir = $basePath . '/blocks';
        
        $mkdir = FileHelper::createDirectory($dir);
        
        $file = $dir . DIRECTORY_SEPARATOR . $blockName . '.php';
        
        if (file_exists($file)) {
            return $this->outputError("File '$file' does already eixsts.");
        }
        
        $creation = file_put_contents($file, $content);
        
        if ($creation) {
            $this->outputSuccess("File '$file' created");   
        } else {
            $this->outputError("Error while creating file '$file'");
        }
    }
    
    private function varCreator($i)
    {
        $name = $this->prompt("#$i: Name of the Variable?", ['required' => true]);
        $label = $this->prompt("#$i: Label for the End-User?", ['required' => true]);
        $type = $this->select("#$i: Type of the Variable?", $this->getVariableTypes());
        
        $v = [
            'var' => Inflector::variablize($name),
            'label' => $label,
            'type' => 'zaa-'.$type,
        ];
        
        if ($this->hasVariableTypeOption($type)) {
            $v['options'] = $this->getVariableTypeOption($type);
        }
        
        return $v;
    }
}