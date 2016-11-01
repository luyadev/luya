<?php

namespace luyatests\core\console\controllers;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\commands\BlockController;

class BlockControllerTest extends LuyaConsoleTestCase
{
    private function getHtml($content)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($content);
        $dom->preserveWhiteSpace = false;
        return $dom->saveHTML();
    }
    
    public function testAppBlock()
    {        
$tpl = <<<'EOT'
<?php

namespace app\blocks;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * My Test Block.
 *
 * Block created with block/create command on LUYA version 1.0.0-RC2-dev.
 */
class MyTestBlock extends PhpBlock
{
    /**
     * @var boolean Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     * in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = true;

    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    public function getBlockGroup()
    {
        return ProjectGroup::class;
    }

    public function name()
    {
        return 'My Test Block';
    }
    
    public function icon()
    {
        return 'extension'; // see the list of icons on: https://design.google.com/icons/
    }
    
    public function config()
    {
        return [
            'vars' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => 'zaa-text'],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => 'zaa-image', 'options' => OPTIONS!],
            ],
            'cfgs' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => 'zaa-text'],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => 'zaa-image', 'options' => OPTIONS!],
            ],
            'placeholders' => [
                 ['var' => 'foo', 'label' => 'Foo'],
                 ['var' => 'bar', 'label' => 'Bar'],
            ],
        ];
    }
    
    public function extraVars()
    {
        return [
            'foo'=>'bar'
        ];
    }

    /**
     * @param {{extras.barfoo}}
     * @param {{extras.foobar}}
     * @param {{vars.bar}}
     * @param {{vars.foo}}
    */
    public function admin()
    {
        return '<p>My Test Block Admin View</p>';
    }
}
EOT;
        $ctrl = new BlockController('id', Yii::$app);
        $ctrl->blockName = 'My Test';
        $ctrl->type = BlockController::TYPE_APP;
        $ctrl->config = [
            'vars' => [
                ['var' => 'foo', 'type' => 'zaa-text', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'zaa-image', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
            ],
            'cfgs' => [
                ['var' => 'foo', 'type' => 'zaa-text', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'zaa-image', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
            ],
            'placeholders' => [
                ['var' => 'foo', 'label' => 'Foo'],
                ['var' => 'bar', 'label' => 'Bar'],
            ],
        ];
        $ctrl->isContainer = true; // make tests
        $ctrl->cacheEnabled = true; // make tests
        $ctrl->extras = ["'foo'=>'bar'"];
        $ctrl->phpdoc = ['{{extras.foobar}}', '{{vars.foo}}', '{{vars.bar}}', '{{extras.barfoo}}'];
        $ctrl->dryRun = true;
        $this->assertEquals($this->getHtml($tpl), $this->getHtml($ctrl->actionCreate()));
    }
    
    public function testModuleBlock()
    {
        $tpl = <<<'EOT'
<?php

namespace luyatests\data\modules\consolemodule\blocks;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * My Test Block.
 *
 * Block created with block/create command on LUYA version 1.0.0-RC2-dev.
 */
class MyTestBlock extends PhpBlock
{
    public $module = 'consolemodule';

    /**
     * @var boolean Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     * in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = true;

    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    public function getBlockGroup()
    {
        return ProjectGroup::class;
    }

    public function name()
    {
        return 'My Test Block';
    }
    
    public function icon()
    {
        return 'extension'; // see the list of icons on: https://design.google.com/icons/
    }
    
    public function config()
    {
        return [
            'vars' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => 'zaa-text'],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => 'zaa-image', 'options' => OPTIONS!],
            ],
            'cfgs' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => 'zaa-text'],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => 'zaa-image', 'options' => OPTIONS!],
            ],
            'placeholders' => [
                 ['var' => 'foo', 'label' => 'Foo'],
                 ['var' => 'bar', 'label' => 'Bar'],
            ],
        ];
    }
    
    public function extraVars()
    {
        return [
            'foo'=>'bar'
        ];
    }

    /**
     * @param {{extras.foobar}}
     * @param {{vars.bar}}
     * @param {{vars.foo}}
    */
    public function admin()
    {
        return '<p>My Test Block Admin View</p>';
    }
}
EOT;
        $ctrl = new BlockController('id', Yii::$app);
        $ctrl->blockName = 'My Test';
        $ctrl->moduleName = 'consolemodule';
        $ctrl->type = BlockController::TYPE_MODULE;
        $ctrl->config = [
            'vars' => [
                ['var' => 'foo', 'type' => 'zaa-text', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'zaa-image', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
            ],
            'cfgs' => [
                ['var' => 'foo', 'type' => 'zaa-text', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'zaa-image', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
            ],
            'placeholders' => [
                ['var' => 'foo', 'label' => 'Foo'],
                ['var' => 'bar', 'label' => 'Bar'],
            ],
        ];
        $ctrl->isContainer = true; // make tests
        $ctrl->cacheEnabled = true; // make tests
        $ctrl->extras = ["'foo'=>'bar'"];
        $ctrl->phpdoc = ['{{extras.foobar}}', '{{vars.foo}}', '{{vars.bar}}'];
        $ctrl->dryRun = true;
        $this->assertEquals($this->getHtml($tpl), $this->getHtml($ctrl->actionCreate()));
    }

    public function testBlockViewFileContent()
    {
        $ctrl = new BlockController('id', Yii::$app);
        $ctrl->viewFileDoc = [
            '$this->varValue(\'foo\');', '$this->varValue(\'foo\');', '$this->extraValue(\'foo\');', '$this->cfgValue(\'foo\');', 
        ];
        
        $view = <<<'EOT'
<?php
/**
 * View file for block: MySuperBlock 
 *
 * @param $this->cfgValue('foo');
 * @param $this->extraValue('foo');
 * @param $this->varValue('foo');
 * @param $this->varValue('foo');
 *
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
EOT;
        $this->assertSame($view, $ctrl->generateViewFile('MySuperBlock'));
    }
}