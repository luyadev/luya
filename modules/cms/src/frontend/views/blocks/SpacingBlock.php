<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
*/
?>
<p class="spacing-block spacing-block--<?= $this->varValue('spacing', 1); ?>"><?php for ($i=1;$i<=$this->varValue('spacing', 1);$i++): ?><br><?php endfor; ?></p>