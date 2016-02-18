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
 * Active Window created at <?php echo date("d.m.Y H:i"); ?> on LUYA Version <?php echo $luya; ?>.
 */
class <?php echo $className; ?> extends \admin\ngrest\base\ActiveWindow
{
	public $module = '@<?php echo $moduleId; ?>';
	
	public $alias = '<?php echo $alias; ?>';
	
	public $icon = 'extension';
	
	/**
	 * Renders the index file of the ActiveWindow.
	 *
	 * @return string The render index file.
	 */
	public function index()
	{
		return $this->render('index', [
			'id' => $this->itemId,
		]);
	}
}