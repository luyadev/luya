<?php

namespace luyatests\core\web;

use luya\web\Twig;

/**
 * @todo readd links (new menu) component and tests
 *
 * @author nadar
 */
class TwigTest extends \luyatests\LuyaWebTestCase
{
    private function getEnv()
    {
        $twig = new Twig();
        $twig->env(new \Twig_Loader_String());

        return $twig;
    }

    /*
    public function testEnvMethod()
    {
        $twig = new Twig();
        $response = $twig->env(new \Twig_Loader_String());
        $this->assertEquals(true, is_object($response));
    }

    public function testFunctions()
    {
        $twig = $this->getEnv();
        $functionList = $twig->getFunctions();

        $this->assertEquals(true, is_array($functionList));
        //$this->assertArrayHasKey('links',$functionList);
        //$this->assertArrayHasKey('linksFindParent',$functionList);
        //$this->assertArrayHasKey('linkActivePart',$functionList);
        $this->assertArrayHasKey('asset', $functionList);
        $this->assertArrayHasKey('filterApply', $functionList);
        $this->assertArrayHasKey('image', $functionList);
        $this->assertArrayHasKey('element', $functionList);
        $this->assertArrayHasKey('t', $functionList);
    }
    */

    public function testNothing()
    {
        // we don't want to remove the twig unit tests, so lets keep this file with this sensless test.
        $this->assertTrue(true);
    }
}
