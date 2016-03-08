<?php

namespace tests\web\cmsadmin\blocks;

use Yii;

class ModuleBlockTest extends \tests\web\Base
{
    public function testRenderingFrontend()
    {
        $block = new \cmsadmin\blocks\ModuleBlock();
        $block->setEnvOption('context', 'frontend');
        $block->setVarValues(['moduleName' => 'ctrlmodule']);

        $twig = Yii::$app->twig->env(new \Twig_Loader_String());

        $this->assertEquals('ctrlmodule/default/index', $block->renderFrontend($twig));
    }

    public function testRenderingAdmin()
    {
        $block = new \cmsadmin\blocks\ModuleBlock();
        $block->setEnvOption('context', 'admin');
        $block->setVarValues(['moduleName' => 'ctrlmodule']);

        $twig = Yii::$app->twig->env(new \Twig_Loader_String());

        $this->assertEquals('', $block->renderFrontend($twig));
    }

    public function testCutomControllerFrontend()
    {
        $block = new \cmsadmin\blocks\ModuleBlock();
        $block->setEnvOption('context', 'frontend');
        $block->setCfgValues(['moduleController' => 'custom', 'moduleAction' => 'bar']);
        $block->setVarValues(['moduleName' => 'ctrlmodule']);

        $twig = Yii::$app->twig->env(new \Twig_Loader_String());

        $this->assertEquals('ctrlmodule/custom/bar', $block->renderFrontend($twig));
    }
}
