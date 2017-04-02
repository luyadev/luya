# Image Lazy Loading

To reduce server load and speed up page requests, LUYA is shipped with a built in {{\luya\lazyload\LazyLoad}} Widget.

## Basic usage

```php
<?= LazyLoad::widget([
        'src' =>  $this->publicHtml . '/path/to/image',
        'width' => 'the-image-width-in-px',
        'height' => 'the-image-height-in-px',
        'extraClass' => 'custom-classes'
    ]); 
?>
```

> The basic usage already provides a no-script fallback.

### Working with Background Images

To use the lazyloader with a background image, for example on a DIV, you just have to set the `attributesOnly` parameter to `true`.

> Remember to use a noscript tag to show the image if no javascript is present.

```php
<div <?= LazyLoad::widget([
        'attributesOnly' => true,
        'src' =>  $this->publicHtml . '/path/to/image',
        'width' => 'the-image-width-in-px',
        'height' => 'the-image-height-in-px',
        'extraClass' => 'custom-classes'
    ]); ?> >
</div>
    
<!-- Fallback for no-js -->
<noscript><div style="background-image: url(<?= $extras['image']->source ?>);"></div></noscript>
```

## Event

Each image loaded will trigger an event `lazyimage-loaded` on the `document`.
The event provides an object with the imageId (ID selector) and the type of the event (`success` or `error`).

```
$(document).on("lazyimage-loaded", function(e, response) {
    $(response.imageId).doStuff();
});
```

## Using LazyLoader with Storage Component

Using the lazyloader with a storage component {{\luya\admin\image\Item}} is easier because you can automatically get the width and height from the storage component:

```php
$image = Yii::$app->storage->getImage(123);
<?= LazyLoad::widget([
    'src' => $image->source,
    'width' => $image->resolutionWidth,
    'height' => $image->resolutionHeight,
]); ?>
```
