<?php
use luya\console\commands\BlockController;
use luya\Boot;

echo "<?php\n";
?>

namespace <?= $namespace; ?>;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;   

/**
 * <?= $name; ?>.
 *
 * Block created with block/create command on LUYA version <?= Boot::VERSION; ?>.
 */
class <?= $className; ?> extends PhpBlock
{
<?php if ($type == BlockController::TYPE_MODULE): ?>
    public $module = '<?= $module; ?>';

<?php endif; ?>
<?php if ($isContainer): ?>
    /**
     * @var boolean Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     * in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = true;

<?php endif; ?>
<?php if ($cacheEnabled): ?>
    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

<?php endif; ?>
    public function getBlockGroup()
    {
        return ProjectGroup::class;
    }

    public function name()
    {
        return '<?= $name; ?>';
    }
    
    public function icon()
    {
        return 'extension'; // see the list of icons on: https://design.google.com/icons/
    }
    
    public function config()
    {
        return [
<?php if (!empty($config['vars'])): ?>
            'vars' => [
<?php foreach ($config['vars'] as $var): ?>
                 ['var' => '<?= $var['var']; ?>', 'label' => '<?= $var['label']; ?>', 'type' => '<?= $var['type']; ?>'<?php if (isset($var['options'])): ?>, 'options' => <?= $var['options']; ?><?php endif; ?>],
<?php endforeach; ?>
            ],
<?php endif; ?>
<?php if (!empty($config['cfgs'])): ?>
            'cfgs' => [
<?php foreach ($config['cfgs'] as $var): ?>
                 ['var' => '<?= $var['var']; ?>', 'label' => '<?= $var['label']; ?>', 'type' => '<?= $var['type']; ?>'<?php if (isset($var['options'])): ?>, 'options' => <?= $var['options']; ?><?php endif; ?>],
<?php endforeach; ?>
            ],
<?php endif; ?>
<?php if (!empty($config['placeholders'])): ?>
            'placeholders' => [
<?php foreach ($config['placeholders'] as $var): ?>
                 ['var' => '<?= $var['var']; ?>', 'label' => '<?= $var['label']; ?>'],
<?php endforeach; ?>
            ],
<?php endif; ?>
        ];
    }
    
<?php if (!empty($extras)): ?>
    public function extraVars()
    {
        return [
<?php foreach ($extras as $extra):?>
            <?= $extra;?>
<?php endforeach;?>

        ];
    }

<?php endif; ?>
    /**
<?php foreach ($phpdoc as $doc): ?>
     * @param <?= $doc; ?>

<?php endforeach; ?>
    */
    public function admin()
    {
        return '<p><?= $name; ?> Admin View</p>';
    }
}