<?php

namespace cmstests\src\frontend;

use Yii;
use cmstests\CmsFrontendTestCase;
use luya\cms\frontend\blocks\ModuleBlock;

class ModuleBlockTest extends CmsFrontendTestCase
{
    public function testRenderingFrontend()
    {
        $block = new ModuleBlock();
        $block->setEnvOption('context', 'frontend');
        $block->setVarValues(['moduleName' => 'CmsUnitModule']);

        $twig = Yii::$app->twig->env(new \Twig_Loader_String());

        $this->assertEquals('cmsunitmodule/default/index', $block->renderFrontend());
    }

    public function testRenderingAdmin()
    {
        $block = new ModuleBlock();
        $block->setEnvOption('context', 'admin');
        $block->setVarValues(['moduleName' => 'CmsUnitModule']);

        $this->assertEquals('{% if vars.moduleName is empty %}<span class="block__empty-text">No module has been provided yet.</span>{% else %}<p><i class="material-icons">developer_board</i> Module integration: <strong>{{ vars.moduleName }}</strong></p>{% endif %}', $block->renderAdmin());
    }

    public function testCutomControllerFrontend()
    {
        $block = new ModuleBlock();
        $block->setEnvOption('context', 'frontend');
        $block->setCfgValues(['moduleController' => 'foo', 'moduleAction' => 'bar']);
        $block->setVarValues(['moduleName' => 'CmsUnitModule']);

        $this->assertEquals('cmsunitmodule/foo/bar', $block->renderFrontend());
    }
}
