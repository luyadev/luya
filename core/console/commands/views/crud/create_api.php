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
 * NgRest API created with LUYA Version <?php echo $luyaVersion; ?>.
 */
class <?php echo $className; ?> extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '<?= $modelClass;?>';
}