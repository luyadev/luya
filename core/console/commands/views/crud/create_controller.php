<?php
/**
 * @var $className
 * @var $modelClass
 * @var $namespace
 * @var $luyaVersion
 */

echo "<?php\n";
?>

namespace <?php echo $namespace; ?>;

/**
 * NgRest API created at <?php echo date("d.m.Y H:i"); ?> on LUYA Version <?php echo $luyaVersion; ?>.
 */
class <?php echo $className; ?> extends \admin\ngrest\base\Controller
{
    /**
     * @var string $modelClass The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '<?= $modelClass;?>';
}
