<?php

namespace admintests\admin\commands;

use Yii;
use admintests\AdminTestCase;
use luya\admin\commands\ActiveWindowController;

class ActiveWindowControllerTest extends AdminTestCase
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
 * File has been created with `aw/create` command on LUYA version 1.0.0. 
 */
class MeinTestActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
    public $module = '@cmsadmin';

    /**
     * Default label if not set in the ngrest model.
     *
     * @return string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
    public function defaultLabel()
    {
        return 'Mein Test Active Window';
    }

    /**
     * Default icon if not set in the ngrest model.
     *
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public function defaultIcon()
    {
        return 'extension';    
    }

    /**
     * The default action which is going to be requested when clicking the ActiveWindow.
     * 
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index', [
            'model' => $this->model,
        ]);
    }
}
EOT;
        
        $this->assertSame($tpl, $content);
    }
}
