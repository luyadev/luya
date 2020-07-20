# Image lazy loading

To reduce server load and speed up page requests, LUYA is shipped with a built in {{\luya\lazyload\LazyLoad}} widget.

You can use the Lazyload widget in 3 different ways:

## Basic usage

This just displays a grey area instead of the image while loading.

> The basic usage already provides a no-script fallback.

```php
<?= LazyLoad::widget([
        'src' =>  $this->publicHtml . '/path/to/image',
        'width' => 'the-image-width-in-px',
        'height' => 'the-image-height-in-px',
        'extraClass' => 'custom-classes'
    ]);
?>
```

## With smaller preview

Display a smaller preview of the image while loading the bigger version.

The plugin doesn't need any width or height informations in this mode, but the smaller
image should have the same dimension.

For example: The Original file has a resolution of 100x100px,
the smaller version should have 10x10, 20x20 or 30x30px.

Based on what styles you apply to your image (`custom-classes`) this might work or not.
You can try to update the placeholder-image styles by using its class and your custom class: `.custom-classes .lazyimage-placeholder-image`

> Includes a noscript fallback.
> Make sure to implement a `nojs` or `no-js` class into you `body` or `html` tag.

```
<?= LazyLoad::widget([
        'src' =>  $this->publicHtml . '/path/to/image',
        'placeholderSrc' => $this->publicHtml . '/path/to/image_very_small',
        'extraClass' => 'custom-classes'
    ]);
?>
```

> Tip: If you use LUYA Admin you can let the [LUYA Filters](app-filters.md) do the work for you.


### Base64 encode

To enable base64 encoding of your placeholder image, you have to make sure that your placeholderSrc is an absolute URL and then set `placeholderAsBase64` to `true`.

```
<?= LazyLoad::widget([
        'src' =>  $this->publicHtml . '/path/to/image',
        'placeholderSrc' => $this->publicHtml . '/path/to/image_very_small',
        'placeholderAsBase64' => true,
        'extraClass' => 'custom-classes'
    ]);
?>
```


## As background image

To use the lazyloader with a background image, e.g. on a `<div class="lazy-image"></div>`, you just have to set the `attributesOnly` parameter to `true`.

> Remember to use a noscript tag to show the image if no javascript is present.
> The plugin doesn't need any width or height information in this mode, make sure to define these
> yourself.

```php
<div <?= LazyLoad::widget([
        'attributesOnly' => true,
        'src' =>  $this->publicHtml . '/path/to/image',
        'extraClass' => 'custom-classes'
    ]); ?> >
</div>

<!-- Fallback for no-js -->
<noscript><div class="custom-classes" style="background-image: url(<?= $extras['image']->source ?>);"></div></noscript>
```

## Using lazy loader with storage component

Using the lazy loader with a storage component {{\luya\admin\image\Item}} is easier because you can automatically get the width and height from the storage component:

```php
$image = Yii::$app->storage->getImage(123);
<?= LazyLoad::widget([
    'src' => $image->source,
    'width' => $image->resolutionWidth,
    'height' => $image->resolutionHeight,
]); ?>
```


## Event

Each image wich is fully loaded will trigger the events `lazyimage-loading` and `lazyimage-loaded` on the `document`.
The `lazyimage-loaded` event provides an object with the imageObject used and the type of the event (`success` or `error`).

```
$(document).on("lazyimage-loaded", function(e, image) {
    console.log(image)
});
```

## Legacy support

If you **don't** need older browser (mainly IE) support, you can disable the legacy support (https://caniuse.com/#feat=intersectionobserver).

```php
<?= LazyLoad::widget([
    'legacySupport' => false
]); ?>
```

## JS Options

To set custom JS options you will have to first disable the automatic init of the lazyload function.

```php
<?= LazyLoad::widget([
    'initJs' => false
]); ?>
```

Then before the closing body tag you can init lazyLoad:

```js
$.lazyLoad({
    // Show console logs
    debug: false,

    // The loader html, customize according
    // to your needs
    loaderHtml: '<div class="loader"></div>',

    // https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API#Intersection_observer_options
    observerOptions: {
        root: document,
        rootMargin: '200px 0px 200px',
        threshold: 0.01
    },
})
```

> There are more options than the ones shown here, but you probably won't need them. If you do, check the lazyload.src.js for all the options.

## Collect new images

If you add images dynamically (with the correct lazyload markup provided by the widget), you can call `$.lazyLoad('collectImages')`.  
This will collect all images that aren't already existing and start to observe them.
