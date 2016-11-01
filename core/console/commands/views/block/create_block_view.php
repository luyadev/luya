<?php
echo "<?php\n";
?>

use Yii;

/**
 * View file for block: <?= $blockClassName; ?> 
 *
<?php foreach ($phpdoc as $doc): ?>
 * @param <?= $doc; ?>

<?php endforeach; ?>
 *
 * @var $this \luya\cms\base\PhpBlockView
 */
?>