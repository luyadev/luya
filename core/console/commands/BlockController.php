<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\helpers\Console;

/**
 * Provide CMS Block helpers
 *
 * @author Basil Suter <basil@nadar.io>
 */
class BlockController extends \luya\console\Command
{
    public $extras = [];
    
    public $phpdoc = [];
    
    private function getModuleProposal()
    {
        $modules = [];
        foreach (Yii::$app->getApplicationModules() as $id => $obj) {
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
            'checkbox-array' => 'radio Buttons with several inputs',
            'file-upload' => 'User can upload a single file',
            'file-array-upload' => 'User can upload severals files',
            'image-upload' => 'creata a image upload form and return the imageId on success',
            'image-array-upload' => 'creates an asrray with image id an caption string',
            'list-array' => 'Creates an array with a key variable value',
            'table' => 'User can dynamic create tables (jsons)',
            'cms-page' => 'Returns CMS page selection tree (only when cms is registered).',
        ];
    }

    private function getVariableTypesOptions()
    {
        return [
            'select' => "[['value' => 1, 'label' => 'Label for Value 1']]",
            'checkbox-array' => "['items' => [['value' => 1, 'label' => 'Label for Value 1']]]",
            'image-upload' => "['no_filter' => false]",
            'image-array-upload' => "['no_filter' => false]",
        ];
    }
    
    private function getExtraVarDef($type, $varName, $func)
    {
        $info = [
            'image-upload' => function ($varName) use ($func) {
                return '$this->zaaImageUpload($this->'.$func.'(\''.$varName.'\'), false, true),';
            },
            'image-array-upload' => function ($varName) use ($func) {
                return '$this->zaaImageArrayUpload($this->'.$func.'(\''.$varName.'\'), false, true),';
            },
            'file-upload' => function ($varName) use ($func) {
                return '$this->zaaFileUpload($this->'.$func.'(\''.$varName.'\'), true),';
            },
            'file-array-upload' => function ($varName) use ($func) {
                return '$this->zaaFileArrayUpload($this->'.$func.'(\''.$varName.'\'), true),';
            },
            'cms-page' => function ($varName) use ($func) {
                return 'Yii::$app->menu->findOne([\'nav_id\' => $this->'.$func.'(\''.$varName.'\', 0)]),';
            },
        ];
        
        if (array_key_exists($type, $info)) {
            return "'".$varName."' => ".$info[$type]($varName);
        }
        
        return false;
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

    /**
     * Wizzard to create a new CMS block.
     *
     * @return number
     */
    public function actionCreate()
    {
        $type = $this->select('Do you want to create an app or module Block?', [
            'app' => 'Creates a project block inside your @app Namespace (casual).', 'module' => 'Creating a block inside a later specified Module.',
        ]);

        $module = false;

        if ($type == 'module' && count($this->getModuleProposal()) === 0) {
            return $this->outputError('Your project does not have Project-Modules registered!');
        }

        if ($type == 'module') {
            $module = $this->select('Choose a module to create the block inside:', $this->getModuleProposal());
        }

        $blockName = $this->prompt('Insert a name for your Block (e.g. HeadTeaser):', ['required' => true]);

        if (substr(strtolower($blockName), -5) !== 'block') {
            $blockName = $blockName.'Block';
        }

        $blockName = Inflector::camelize($blockName);

        // vars

        $config = [
            'vars' => [], 'cfgs' => [], 'placeholders' => [],
        ];

        $doConfigure = $this->confirm('Would you like to configure this Block? (vars, cfgs, placeholders)', false);

        if ($doConfigure) {
            $doVars = $this->confirm('Add new Variable (vars)?', false);
            $i = 1;
            while ($doVars) {
                $item = $this->varCreator('Variabel (vars) #'.$i, 'var');
                $this->phpdoc[] = '{{vars.'.$item['var'].'}}';
                $config['vars'][] = $item;
                $doVars = $this->confirm('Add one more?', false);
                ++$i;
            }
            $doCfgs = $this->confirm('Add new Configuration (cgfs)?', false);
            $i = 1;
            while ($doCfgs) {
                $item = $this->varCreator('Configration (cfgs) #'.$i, 'cfg');
                $this->phpdoc[] = '{{cfgs.'.$item['var'].'}}';
                $config['cfgs'][] = $item;
                $doCfgs = $this->confirm('Add one more?', false);
                ++$i;
            }
            $doPlaceholders = $this->confirm('Add new Placeholder (placeholders)?', false);
            $i = 1;
            while ($doPlaceholders) {
                $item = $this->placeholderCreator('Placeholder (placeholders) #'.$i);
                $this->phpdoc[] = '{{placeholders.'.$item['var'].'}}';
                $config['placeholders'][] = $item;
                $doPlaceholders = $this->confirm('Add one more?', false);
                ++$i;
            }
        }

        if ($module) {
            $moduleObject = Yii::$app->getModule($module);
            $basePath = $moduleObject->basePath;
            $ns = $moduleObject->getNamespace();
        } else {
            $basePath = Yii::$app->basePath;
            $ns = 'app';
        }

        $ns = $ns.'\\blocks';

        $content = '<?php'.PHP_EOL.PHP_EOL;
        $content .= 'namespace '.$ns.';'.PHP_EOL.PHP_EOL;
        $content .= 'use Yii;'.PHP_EOL.PHP_EOL;
        $content .= '/**'.PHP_EOL;
        $content .= ' * Block created with Luya Block Creator Version '.\luya\Boot::VERSION.' at '.date('d.m.Y H:i').PHP_EOL;
        $content .= ' */'.PHP_EOL;
        $content .= 'class '.$blockName.' extends \luya\cms\base\PhpBlock'.PHP_EOL;
        $content .= '{'.PHP_EOL;

        if ($module) {
            $content .= PHP_EOL.'    public $module = \''.$module.'\';'.PHP_EOL.PHP_EOL;
        }

        // properties for caching
        $content .= '    /**'.PHP_EOL;
        $content .= '     * @var bool Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed'.PHP_EOL;
        $content .= '     * in a different way for a better user experience. Container block will not display isDirty colorizing.'.PHP_EOL;
        $content .= '     */'.PHP_EOL;
        $content .= '    public $isContainer = false;'.PHP_EOL . PHP_EOL;
        $content .= '    /**'.PHP_EOL;
        $content .= '     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.'.PHP_EOL;
        $content .= '     */'.PHP_EOL;
        $content .= '    public $cacheEnabled = false;'.PHP_EOL . PHP_EOL;
        $content .= '    /**'.PHP_EOL;
        $content .= '     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true'.PHP_EOL;
        $content .= '     */'.PHP_EOL;
        $content .= '    public $cacheExpiration = 3600;'.PHP_EOL . PHP_EOL;
        
        // method name
        $content .= '    public function name()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return \''.Inflector::humanize($blockName).'\';'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;

        // method icon
        $content .= '    public function icon()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return \'extension\'; // choose icon from: https://design.google.com/icons/'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;

        $content .= '    public function config()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return ['.PHP_EOL;
        // get vars
        if (count($config['vars'])) {
            $content .= '           \'vars\' => ['.PHP_EOL;
            foreach ($config['vars'] as $k => $v) {
                $content .= '               [\'var\' => \''.$v['var'].'\', \'label\' => \''.$v['label'].'\', \'type\' => \''.$v['type'].'\'';
                if (isset($v['options'])) {
                    $content .= ', \'options\' => '.$v['options'];
                }
                $content .= '],'.PHP_EOL;
            }
            $content .= '           ],'.PHP_EOL;
        }
        // get cfgs
        if (count($config['cfgs'])) {
            $content .= '           \'cfgs\' => ['.PHP_EOL;
            foreach ($config['cfgs'] as $k => $v) {
                $content .= '               [\'var\' => \''.$v['var'].'\', \'label\' => \''.$v['label'].'\', \'type\' => \''.$v['type'].'\'';
                if (isset($v['options'])) {
                    $content .= ', \'options\' => '.$v['options'];
                }
                $content .= '],'.PHP_EOL;
            }
            $content .= '           ],'.PHP_EOL;
        }
        // get placeholders
        if (count($config['placeholders'])) {
            $content .= '           \'placeholders\' => ['.PHP_EOL;
            foreach ($config['placeholders'] as $k => $v) {
                $content .= '               [\'var\' => \''.$v['var'].'\', \'label\' => \''.$v['label'].'\'],'.PHP_EOL;
            }
            $content .= '           ],'.PHP_EOL;
        }
        $content .= '        ];'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;

        // method extraVars
        $content .= '    /**'.PHP_EOL;
        $content .= '     * Return an array containg all extra vars. The extra vars can be access within the `$extras` array.'.PHP_EOL;
        $content .= '     */'.PHP_EOL;
        $content .= '    public function extraVars()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return ['.PHP_EOL;
        foreach ($this->extras as $x) {
            $content .= '            '.$x.PHP_EOL;
        }
        $content .= '        ];'.PHP_EOL;
        $content .= '    }'.PHP_EOL.PHP_EOL;

        // method twigAdmin
        $content .= '    /**'.PHP_EOL;
        $content .= '     * Available twig variables:'.PHP_EOL;
        foreach ($this->phpdoc as $doc) {
            $content .= '     * @param '.$doc.PHP_EOL;
        }
        $content .= '     */'.PHP_EOL;
        $content .= '    public function admin()'.PHP_EOL;
        $content .= '    {'.PHP_EOL;
        $content .= '        return \'<p>Block Admin</p>\';'.PHP_EOL;
        $content .= '    }'.PHP_EOL;

        $content .= '}'.PHP_EOL;

        $dir = $basePath.'/blocks';

        $mkdir = FileHelper::createDirectory($dir);

        $file = $dir.DIRECTORY_SEPARATOR.$blockName.'.php';

        if (file_exists($file)) {
            return $this->outputError("File '$file' does already eixsts.");
        }

        $creation = file_put_contents($file, $content);

        if ($creation) {
            return $this->outputSuccess("File '$file' created");
        }

        return $this->outputError("Error while creating file '$file'");
    }

    private function placeholderCreator($prefix)
    {
        $this->output(PHP_EOL.'-> Create new '.$prefix, Console::FG_YELLOW);
        $name = $this->prompt('Variable Name:', ['required' => true]);
        $label = $this->prompt('End-User Label:', ['required' => true]);

        $v = [
            'var' => Inflector::variablize($name),
            'label' => $label,
        ];

        $this->output('Added '.$prefix.PHP_EOL, Console::FG_GREEN);

        return $v;
    }

    /**
     *
     * @param unknown $prefix
     * @param string $type 'var', 'cfg'
     * @return multitype:string Ambigous <string, array>
     */
    private function varCreator($prefix, $typeCast)
    {
        $this->output(PHP_EOL.'-> Create new '.$prefix, Console::FG_YELLOW);
        $name = $this->prompt('Variable Name:', ['required' => true]);
        $label = $this->prompt('End-User Label:', ['required' => true]);
        $type = $this->select('Variable Type:', $this->getVariableTypes());

        $v = [
            'var' => Inflector::variablize($name),
            'label' => $label,
            'type' => 'zaa-'.$type,
        ];

        if ($this->hasVariableTypeOption($type)) {
            $v['options'] = $this->getVariableTypeOption($type);
        }
        
        if ($typeCast == 'var') {
            $func = 'getVarValue';
        } else {
            $func = 'getCfgValue';
        }
        
        $extra = $this->getExtraVarDef($type, $v['var'], $func);
        
        if ($extra) {
            $this->phpdoc[] = '{{extras.'.$v['var'].'}}';
            $this->extras[] = $extra;
        }

        $this->output('Added '.$prefix.PHP_EOL, Console::FG_GREEN);

        return $v;
    }
}
