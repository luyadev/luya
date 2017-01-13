<h1>Suchen</h1>
<p>Sie haben nach <b><?php echo $query; ?></b> gesucht.</p>

<h2><?php echo count($results); ?> Resultate</h2>
<ul>
<?php foreach ($results as $item): ?>
    <li><a href="<?php echo $item->clickUrl; ?>"><?php echo $item->title; ?></a>
    
        <p style="background-color:red;"><?php echo $item->preview($query); ?></p>
    </li>
<?php endforeach; ?>
</ul>