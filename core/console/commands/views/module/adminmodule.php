<?php
use luya\base\Boot;

echo "<?php\n";
?>

namespace <?= $ns ?>\admin;

/**
 * Admin module of <?= $name; ?>.
 *
 * Created with LUYA Version <?= Boot::VERSION; ?> at <?= date("d.m.Y"); ?> 
 */
class Module extends \luya\admin\base\Module
{

}