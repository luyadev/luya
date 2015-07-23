News Modul
==========
Das Frontend Modul News gilt als das Gegnstück zum News-Admin Modul. Der Aufbau ist denkbar einfach, es gibt nur ein Controller, den `DefaultController`. Dieser bietet zwei Methoden an, die `actionIndex()` und `actionDetail()`. Beide rufen den jeweils im Projekt implentierten *View* auf.

Index View
----------

Hier ist eine Beispielimplementation des `Index` Views:

```php
<?php foreach($model::getAvailableNews() as $item): ?>

    <div class="row">
	    <h2>
     	   <?= $item->title ?></br>
           <?= $item->timestamp_create ?></br>
       </h2>
	       <div class="row">
    	       <?php if($item->image_id): ?>
               		<img src="<?= yii::$app->storage->image->filterApply($item->image_id, 'gallery-image-thumbnail'); ?>" class="news__image img-thumbnail">
               <?php endif ?>
	           </div>
               <p><?= $item->text ?></p>
               <a href="<?= $item->getDetailUrl(); ?>">Mehr lesen</a>
		    </div>
        </div>
    </div>
<?php endforeach; ?>
```

Es wird die statische Methode `getAvailableNews()` genutzt, um alle aktuell sichtbaren News aus dem News-Admin Modul zu holen. Diese werden dann entsprechend dem Viewcode dargestellt. Der Titel und das Erstelldatum der News werden angezeigt. Ausserdem wird das entsprechende News Bild mit dem korrekten Filteraufruf dargestellt, aber nur falls ein Bild vorhanden ist.   Danach wird der Text der News und der Link zur vollständigen Darstellung angezeigt.

Detail View
-----------

Hier wieder ein Beispiel für die Implementation eines `Detail` Views:

```php
<div class="row">
	<h1>
    	<?= $model->title ?>
        <?= $model->timestamp_create ?>
   </h1>
</div>

<div class="row">
	<a href="<?= \yii::$app->storage->image->filterApply($model->image_id, 'lightbox'); ?>">
    	<img src="<?= \yii::$app->storage->image->filterApply($model->image_id, 'large-crop'); ?>" />
   </a>
</div>
<p>
	<?= $model->text ?>
</p>
```

Die Umsetzung erfolgte analog zum `Index` View. Zusätzlich könnte man noch die Bilder (also nicht das Thumbnailbild) mit `$item->image_list` darstellen oder auf Dateianhang mit `$item->file_list` verweisen.


