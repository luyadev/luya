<?php

namespace tests\web\cmsadmin\models;

use cmstests\CmsFrontendTestCase;
use luya\cms\models\NavItem;

class NavItemTest extends CmsFrontendTestCase
{
    public function testSlugifyAlias()
    {
        $model = new NavItem();

        $model->alias = "äÄöÖüÜß<>";
        $model->slugifyAlias();
        $this->assertSame("ääööüüß", $model->alias);

        $model->alias = "這是      LUYA";
        $model->slugifyAlias();
        $this->assertSame("這是-luya", $model->alias);

        $model->alias = "a1Zあ新~!@#$^&*()_[];',:?";
        $model->slugifyAlias();
        $this->assertSame("a1zあ新~!@#$^&*()_[];',:?", $model->alias);
    }
}
