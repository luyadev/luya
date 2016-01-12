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

/**
 * Active Window created at <?= date("d.m.Y H:i"); ?> on LUYA Version <?= $luya; ?>.
 */
class <?= $className; ?> extends \luya\ngrest\base\ActiveWindow
{
	public $module = '@<?= $moduleId; ?>';
	
	public $alias = '<?= $alias; ?>';
	
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