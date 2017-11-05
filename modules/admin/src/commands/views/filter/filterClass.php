<?php
echo "<?php\n";
?>

namespace app\filters;

use luya\admin\base\Filter;

/**
 * <?= $name; ?> Filter.
 *
 * <?= $luyaText; ?> 
 */
class <?= $className; ?> extends Filter
{
    public static function identifier()
    {
        return '<?= $identifier; ?>';
    }

    public function name()
    {
        return '<?= $name; ?>';
    }

    public function chain()
    {
        return [
<?php foreach ($chain as $filter => $args): ?>
            [<?= $filter; ?>, [
<?php foreach ($args as $k => $v): ?>
                '<?= $k; ?>' => '<?= $v; ?>',
<?php endforeach; ?>
            ]],
<?php endforeach; ?>
        ];
    }
}