index.php
=========
```
<?php foreach($model::find()->all() as $item): ?>
<pre>
<? print_r($item->toArray()); ?>
</pre>
<p><a href="<?= $item->getDetailUrl(); ?>">News Detail Url</a></p>
<?php endforeach; ?>
```

detail.php
==========
```
<pre>
<? print_r($model->toArray()); ?>
</pre>
```