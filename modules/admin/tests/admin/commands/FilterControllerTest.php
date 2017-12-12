<?php

namespace admintests\admin\commands;

use admintests\AdminTestCase;
use luya\console\Application;
use luya\admin\commands\FilterController;

class FilterControllerTest extends AdminTestCase
{
    public function testIndexAction()
    {
        $app = new Application($this->getConfigArray());
        $ctrl = new FilterController('index', $app);
        
        $this->assertTrue(is_object($ctrl));
    
        $buff = <<<'EOT'
<?php

namespace app\filters;

use luya\admin\base\Filter;

/**
 * Nam Filter.
 *
 * File has been created with `block/create` command on LUYA version 1.0.0. 
 */
class className extends Filter
{
    public static function identifier()
    {
        return 'idf';
    }

    public function name()
    {
        return 'Nam';
    }

    public function chain()
    {
        return [
            [method, [
                'arg' => 'v',
                'foo' => 'bar',
            ]],
        ];
    }
}
EOT;

        $render = $this->removeNewline($ctrl->generateClassView('idf', 'Nam', ['method' => ['arg' => 'v', 'foo' => 'bar']], 'className'));
        $this->assertSame($this->removeNewline($buff), $render);
    }
}
