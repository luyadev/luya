<?php

namespace luyatests\core\console\commands;

use luya\console\commands\ModuleController;
use luyatests\LuyaConsoleTestCase;
use Yii;

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
 * File has been created with `module/create` command.
 *
 * @author
 * @since 1.0.0
 */
class Module extends \luya\admin\base\Module
{

}
EOT;
        $this->assertSameNoSpace($tpl, $content);
    }

    public function testRenderFrontend()
    {
        $ctrl = new ModuleController('module', Yii::$app);

        $content = $ctrl->renderFrontend([], 'foo', 'app\\modules');
        $tpl = <<<'EOT'
<?php

namespace app\modules\frontend;

/**
 * Foo Frontend Module.
 *
 * File has been created with `module/create` command.
 *
 * @author
 * @since 1.0.0
 */
class Module extends \luya\base\Module
{

}
EOT;
        $this->assertSameNoSpace($tpl, $content);
    }

    public function testRenderReadme()
    {
        $ctrl = new ModuleController('module', Yii::$app);

        $content = $ctrl->renderReadme([], 'foo', 'app\\modules');
        $tpl = <<<'EOT'
# Foo Module

File has been created with `module/create` command. 

## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
    'modules' => [
        // ...
        'foofrontend' => [
            'class' => 'app\modules\frontend\Module',
            'useAppViewPath' => true, // When enabled the views will be looked up in the @app/views folder, otherwise the views shipped with the module will be used.
        ],
        'fooadmin' => 'app\modules\admin\Module',
        // ...
    ],
];
```

EOT;
        $this->assertSame($tpl, $content);
    }
}
