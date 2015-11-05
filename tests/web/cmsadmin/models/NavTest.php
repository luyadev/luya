<?php

namespace tests\web\cmsadmin\models;

use cmsadmin\models\Nav;

class NavTest extends \tests\web\Base
{
    public function testFindContent()
    {
        $this->assertEquals(false, Nav::findContent(0));
        $this->assertEquals(null, Nav::findContent(1));
    }

    /*
    public function testCreatePage()
    {
        $model = new Nav();
        $response = $model->createPage(0, 1, 1, 'foo-title', 'foo-rewrite', 1);
        
        var_dump($response);
    }
    */
}
