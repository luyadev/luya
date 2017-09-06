<?php

namespace luyatests\core\console\commands;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\commands\ModuleController;

class ModuleControllerTest extends LuyaConsoleTestCase
{
    public function testRenderAdmin()
    {
        $ctrl = new ModuleController('module', Yii::$app);
        
        $content = $ctrl->renderAdmin([], 'foo', 'app\\modules');
        $tpl = <<<'EOT'
<?php

namespace app\modules\admin;

/**
 * Foo Admin Module.
 *
 * File has been created with `module/create` command on LUYA version 1.0.0-dev. 
 */
class Module extends \luya\admin\base\Module
{

}
EOT;
        $this->assertSame($tpl, $content);
    }
    
    public function testRenderFrontend()
    {
        $ctrl = new ModuleController('module', Yii::$app);
        
        $content = $ctrl->renderFrontend([], 'foo', 'app\\modules');
        $tpl = <<<'EOT'
<?php

namespace app\modules\frontend;

/**
 * Foo Admin Module.
 *
 * File has been created with `module/create` command on LUYA version 1.0.0-dev. 
 */
class Module extends \luya\base\Module
{

}
EOT;
        $this->assertSame($tpl, $content);
    }
    
    public function testRenderReadme()
    {
        $ctrl = new ModuleController('module', Yii::$app);
        
        $content = $ctrl->renderReadme([], 'foo', 'app\\modules');
        $tpl = <<<'EOT'
# Foo Module
 
File has been created with `module/create` command on LUYA version 1.0.0-dev. 
 
## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
    'modules' => [
        // ...
        'foo' => 'app\modules\frontend\Module',
        'fooadmin' => 'app\modules\admin\Module',
        // ...
    ],
];
```
EOT;
        $this->assertSame($tpl, $content);
    }
}
