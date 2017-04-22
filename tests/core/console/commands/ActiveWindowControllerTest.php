<?php

namespace luyatests\core\console\commands;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\commands\ActiveWindowController;

class ActiveWindowControllerTest extends LuyaConsoleTestCase
{
    public function testPhpViewRenderContent()
    {
        $ctrl = new ActiveWindowController('id', Yii::$app);
        
        $content = $ctrl->renderWindowClassView('MeinTestActiveWindow', 'path\\to\\aws', 'cmsadmin');
        
        $tpl = <<<'EOT'
<?php

namespace path\to\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Mein Test Active Window.
 *
 * File has been created with `aw/create` command on LUYA version 1.0.0-dev. 
 */
class MeinTestActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
    public $module = '@cmsadmin';
	
    /**
     * @var string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
    public $alias = 'Mein Test Active Window';
	
    /**
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public $icon = 'extension';
	
    /**
     * The default action which is going to be requested when clicking the ActiveWindow.
     * 
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index', [
            'id' => $this->itemId,
        ]);
    }
}
EOT;
        
        $this->assertSame($tpl, $content);
    }
}
