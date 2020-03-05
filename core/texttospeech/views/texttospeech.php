<?php

?>
<div id="<?= $id; ?>" class="<?= $containerClass; ?>">
<?php foreach ($buttons as $btn): ?>
    <button class="<?= $buttonClass; ?> <?= $buttonClass; ?>-<?= $btn['id']; ?>" id="<?= $btn['id']; ?>"><?= $btn['svg']; ?></button>
<?php endforeach; ?>
</div>