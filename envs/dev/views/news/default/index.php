<h1>News Index Overview</h1>
<pre>
<? foreach($model::getAvailableNews() as $n): ?>
    <p><?= $n->title; ?></p>
    <a href="<?= $n->detailUrl; ?>"><?= $n->detailUrl; ?></a>
<? endforeach; ?>
</pre>