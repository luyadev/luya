<div style="padding:20px;">

    <div style="padding:20px; background-color:#F0F0F0;">
    <span style="font-size:18px;">Global Styles</span>
    </div>
    <div style="padding:10px; border:5px solid #F0F0F0; margin-bottom:20px;">
        <h1>Heading 1</h1>
        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <h4>Heading 4</h4>
        <h5>Heading 5</h5>
        <h6>Heading 6</h6>
        <p>Pargraph Pargraph Pargraph Pargraph Pargraph Pargraph Pargraph Pargraph</p>
        <ul>
            <li>Ul-Li-Element #1</li>
            <li>Ul-Li-Element #2</li>
            <li>Ul-Li-Element #3</li>
        </ul>
        
        <ol>
            <li>Ol-Li-Element #1</li>
            <li>Ol-Li-Element #2</li>
            <li>Ol-Li-Element #3</li>
        </ol>
        <a href="#">Link Element</a>
    </div>

<?php foreach ($containers as $item): ?>

<div style="padding:20px; background-color:#F0F0F0;">
<span style="font-size:18px;"><?= $item['name']; ?></span> <i>(<?= implode(', ', $item['args']); ?>)</i>
</div>
<div style="padding:10px; border:5px solid #F0F0F0; margin-bottom:20px;">
        <?= $item['html']; ?>
</div>
<?php endforeach; ?>
</div>