Crawler
=======

render view beispiel `crawler/default/index`:

```php
<h1>Suchen</h1>
<p>Sie haben nach <b><?php echo $query; ?></b> gesucht.</p>

<h2><?php echo count($results); ?> Resultate</h2>
<ul>
<?php foreach($results as $item): ?>
    <li><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
    
        <p style="background-color:red;"><?php echo $item->preview($query); ?></p>
    </li>
<?php endforeach; ?>
</ul>
```


ASYNC
-----

Für Async Searchs kann der Restcontroller verwendet werden, hier ein Jquery beispiel:

> Achtung die Url Composition prefix muss gegen sein für mehrsprachige Urls.

```

var url = '<?php echo \luya\helpers\Url::toInternal(['crawler/rest/index']); ?>';

$.ajax({
	url : url 
}).done(function(response) {
	console.log(response);
});

```