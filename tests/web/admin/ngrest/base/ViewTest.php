<?php

namespace tests\web\admin\ngrest\base;

use admin\ngrest\base\View;

class ViewTest extends \tests\web\Base
{
    /**
     * @expectedException Exception
     */
    public function testIdException()
    {
        $view = new View();
        // exception: The ActiveWindow View 'id' can't be empty!
        $view->render('file.php');
    }

    /**
     * @expectedException Exception
     */
    public function testModuleException()
    {
        $view = new View();
        $view->id = 'testaw';
        // exception: The ActiveWindow View 'module' can't be empty!
        $view->render('file.php');
    }
}
