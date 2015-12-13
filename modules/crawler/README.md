Crawler
=======

render view beispiel `crawler/default/index`:

```php
<h1>Suchen</h1>
<p>Sie haben nach <b><?= $query; ?></b> gesucht.</p>

<h2><?= count($results); ?> Resultate</h2>
<ul>
<? foreach($results as $item): ?>
    <li><a href="<?= $item->url; ?>"><?= $item->title; ?></a>
    
        <p style="background-color:red;"><?= $item->preview($query); ?></p>
    </li>
<? endforeach; ?>
</ul>
```


ASYNC
-----

Für Async Searchs kann der Restcontroller verwendet werden, hier ein Jquery beispiel:

> Achtung die Url Composition prefix muss gegen sein für mehrsprachige Urls.

```

var url = '<?= \luya\helpers\Url::toInternal(['crawler/rest/index']); ?>';

$.ajax({
	url : url 
}).done(function(response) {
	console.log(response);
});

```