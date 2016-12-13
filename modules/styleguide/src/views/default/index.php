<?php foreach ($containers as $item): ?>
    <div style="padding:20px; text-align:center;">
        <span style="font-size:18px;"><?= $item['name']; ?><i>(<?= implode(', ', $item['args']); ?>)</i></span>
    </div>
    <?= $item['tag']; ?>
<?php endforeach; ?>

<div style="padding:20px; text-align:center;">
        <span style="font-size:18px;">Global Styles</span>
</div>
<?= $global; ?>