<?php

?>
<div id="<?= $id; ?>" class="<?= $containerClass; ?>">
<?php foreach ($buttons as $btn): ?>
    <button type="button" style="height:<?= $buttonSize; ?>px; width:<?= $buttonSize; ?>px;" class="<?= $buttonClass; ?> <?= $buttonClass; ?>-<?= $btn['id']; ?>" id="<?= $btn['id']; ?>"><?= $btn['content']; ?></button>
<?php endforeach; ?>
</div>