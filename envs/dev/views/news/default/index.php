<h1>News Index Overview</h1>
<pre>
<?php foreach($model::getAvailableNews() as $n): ?>
    <p><?php echo $n->title; ?></p>
    <a href="<?php echo $n->detailUrl; ?>"><?php echo $n->detailUrl; ?></a>
<?php endforeach; ?>
</pre>