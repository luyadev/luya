<?php

namespace cmstests\src\frontend\commands;

use Yii;
use cmstests\CmsFrontendTestCase;
use luya\cms\frontend\commands\BlockController;

class BlockControllerTest extends CmsFrontendTestCase
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
 * File has been created with `block/create` command on LUYA version 1.0.0. 
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

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return ProjectGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'My Test Block';
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'extension'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => self::TYPE_TEXT],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => self::TYPE_IMAGEUPLOAD, 'options' => OPTIONS!],
            ],
            'cfgs' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => self::TYPE_TEXT],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => self::TYPE_IMAGEUPLOAD, 'options' => OPTIONS!],
            ],
            'placeholders' => [
                 ['var' => 'foo', 'label' => 'Foo'],
                 ['var' => 'bar', 'label' => 'Bar'],
            ],
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function extraVars()
    {
        return [
            'foo'=>'bar'
        ];
    }

    /**
     * {@inheritDoc} 
     *
     * @param {{extras.barfoo}}
     * @param {{extras.foobar}}
     * @param {{vars.bar}}
     * @param {{vars.foo}}
    */
    public function admin()
    {
        return '</p><h5 class="mb-3">My Test Block</h5>' .
            '<table class="table table-bordered">' .
            '{% if vars.foo is not empty %}' .
            '<tr><td><b>Foo</b></td><td>{{vars.foo}}</td></tr>' .
            '{% endif %}'.
            '{% if vars.bar is not empty %}' .
            '<tr><td><b>Bar</b></td><td>{{vars.bar}}</td></tr>' .
            '{% endif %}'.
            '{% if cfgs.foo is not empty %}' .
            '<tr><td><b>Foo</b></td><td>{{cfgs.foo}}</td></tr>' .
            '{% endif %}'.
            '{% if cfgs.bar is not empty %}' .
            '<tr><td><b>Bar</b></td><td>{{cfgs.bar}}</td></tr>' .
            '{% endif %}'.
            '</table>';
    }
}
EOT;
        $ctrl = new BlockController('id', Yii::$app);
        $ctrl->blockName = 'My Test';
        $ctrl->type = BlockController::TYPE_APP;
        $ctrl->config = [
            'vars' => [
                ['var' => 'foo', 'type' => 'self::TYPE_TEXT', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'self::TYPE_IMAGEUPLOAD', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
            ],
            'cfgs' => [
                ['var' => 'foo', 'type' => 'self::TYPE_TEXT', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'self::TYPE_IMAGEUPLOAD', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
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

namespace luya\cms\frontend\blocks;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * My Test Block.
 *
 * File has been created with `block/create` command on LUYA version 1.0.0. 
 */
class MyTestBlock extends PhpBlock
{
    /**
     * @var string The module where this block belongs to in order to find the view files.
     */
    public $module = 'cms';

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

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return ProjectGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'My Test Block';
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'extension'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => self::TYPE_TEXT],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => self::TYPE_IMAGEUPLOAD, 'options' => OPTIONS!],
            ],
            'cfgs' => [
                 ['var' => 'foo', 'label' => 'Foo', 'type' => self::TYPE_TEXT],
                 ['var' => 'bar', 'label' => 'Bar', 'type' => self::TYPE_IMAGEUPLOAD, 'options' => OPTIONS!],
            ],
            'placeholders' => [
                 ['var' => 'foo', 'label' => 'Foo'],
                 ['var' => 'bar', 'label' => 'Bar'],
            ],
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function extraVars()
    {
        return [
            'foo'=>'bar'
        ];
    }

    /**
     * {@inheritDoc} 
     *
     * @param {{extras.foobar}}
     * @param {{vars.bar}}
     * @param {{vars.foo}}
    */
    public function admin()
    {
        return '</p><h5 class="mb-3">My Test Block</h5>' .
            '<table class="table table-bordered">' .
            '{% if vars.foo is not empty %}' .
            '<tr><td><b>Foo</b></td><td>{{vars.foo}}</td></tr>' .
            '{% endif %}'.
            '{% if vars.bar is not empty %}' .
            '<tr><td><b>Bar</b></td><td>{{vars.bar}}</td></tr>' .
            '{% endif %}'.
            '{% if cfgs.foo is not empty %}' .
            '<tr><td><b>Foo</b></td><td>{{cfgs.foo}}</td></tr>' .
            '{% endif %}'.
            '{% if cfgs.bar is not empty %}' .
            '<tr><td><b>Bar</b></td><td>{{cfgs.bar}}</td></tr>' .
            '{% endif %}'.
            '</table>';
    }
}
EOT;
        $ctrl = new BlockController('id', Yii::$app);
        $ctrl->blockName = 'My Test';
        $ctrl->moduleName = 'cms';
        $ctrl->type = BlockController::TYPE_MODULE;
        $ctrl->config = [
            'vars' => [
                ['var' => 'foo', 'type' => 'self::TYPE_TEXT', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'self::TYPE_IMAGEUPLOAD', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
            ],
            'cfgs' => [
                ['var' => 'foo', 'type' => 'self::TYPE_TEXT', 'label' => 'Foo'],
                ['var' => 'bar', 'type' => 'self::TYPE_IMAGEUPLOAD', 'label' => 'Bar', 'options'=> 'OPTIONS!'],
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
 * File has been created with `block/create` command on LUYA version 1.0.0. 
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
