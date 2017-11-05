<?php
/**
 * @var $className
 * @var $namespace
 * @var $luya
 * @var $moduleId
 * @var $alias
 */

echo "<?php\n";
?>

namespace <?= $namespace; ?>;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * <?= $alias; ?>.
 *
 * <?= $luyaText; ?> 
 */
class <?= $className; ?> extends ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
    public $module = '@<?= $moduleId; ?>';

    /**
     * Default label if not set in the ngrest model.
     *
     * @return string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
    public function defaultLabel()
    {
        return '<?= $alias; ?>';
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