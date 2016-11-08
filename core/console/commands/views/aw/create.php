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

namespace <?php echo $namespace; ?>;

/**
 * ActiveWindow created with LUYA Version <?= $luya; ?>.
 */
class <?php echo $className; ?> extends \luya\admin\ngrest\base\ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
	public $module = '@<?php echo $moduleId; ?>';
	
    /**
     * @var string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
	public $alias = '<?php echo $alias; ?>';
	
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