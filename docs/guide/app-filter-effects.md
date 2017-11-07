# Filter Chain Effects

The name effect is maybe a little bit confusing, as `crop` or `thumbnail` does not sound like a effect at all, but there are other things which are effects. Actually an effect is an array item in the `chain()` method of a [Filter](app-filters.md).

Each chain effect can have several arguments which changes the behavior of the effect. Since we have integrated the [Yii 2 Imagine Extension](https://github.com/yiisoft/yii2-imagine) the arguments to passed are equals to the supported methods in the extension and the thumbnail behavior has been strongly improved in order to calculate images based on values without doing the math on your own.

### Available Effects

|Name       |Description
|---        |---
|thumbnail  |Create a thumbnail based on the height/width or calulate missing heigt/widths. You can also directly crop images with the thumbnail effect.
|crop       |Crop an image to defined size on the given point/location of the image

## Thumbnail

The most powerfull and commonly used effect is thumbnail.

|Option     |Required   |Description
|---        |---        |---
|width      |yes        |The width in pixels to create the thumbnail, can be null to auto calculate the size to keep the ratio.
|height     |yes        |The height in pixels to create the thumbnail, can be null to auto calculate the size to keep the ratio.
|mode       |no         |Mode of resizing original image to use in case both width and height specified, by default its `self::THUMBNAIL_MODE_OUTBOUND`.
|saveOptions|no         |Array with options to pass to the imagine `save()` method, example quality.

If one of thumbnail dimensions is set to `null`, another one is calculated automatically based on aspect ratio of original image. Note that calculated thumbnail dimension may vary depending on the source image in this case.

If both dimensions are specified, resulting thumbnail would be exactly the width and height specified. How it's achieved depends on the mode.

If `self::THUMBNAIL_MODE_OUTBOUND` mode is used, which is default, then the thumbnail is scaled so that its smallest side equals the length of the corresponding side in the original image. Any excess outside of the scaled thumbnail’s area will be cropped, and the returned thumbnail will have the exact width and height specified.

If thumbnail mode is `self::THUMBNAIL_MODE_INSET`, the original image is scaled down so it is fully contained within the thumbnail dimensions. The rest is filled with background that could be configured via [[Image::$thumbnailBackgroundColor]] and [[Image::$thumbnailBackgroundAlpha]].

Generate Thumbnail but calculate the height for the given width of 500

```php
[self::EFFECT_THUMBNAIL, [
    'width' => 500, 
    'height' => null,
    'saveOptions' => ['quality' => 80]]
]
```
Generate thumbnail croped to 500x500 pixel:

```php
[self::EFFECT_THUMBNAIL, [
    'width' => 500, 
    'height' => 500,
    'saveOptions' => ['quality' => 80]]
]
```

Generate thumbnail croped to 500x500 pixel but does at background color to fill up the file if it does not match the Inset bounds.

```php
[self::EFFECT_THUMBNAIL, [
    'width' => 500, 
    'height' => 500,
    'mode' => self::THUMBNAIL_MODE_INSET,
    'saveOptions' => ['quality' => 80]]
]
```

## Crop

|Option     |Requied    |Description
|---        |---        |---
|width      |yes        |The crop width
|height     |yes        |The crop height
|start      |no         |The starting point. This must be an array with two elements representing `x` and `y` coordinates. If not provided its `[0,0]`.
|saveOptions|no         |Array with options to pass to the imagine `save()` method, example quality.

Crop the image to 500x500 pixel.

```php
[self::EFFECT_CROP, [
    'width' => 500, 
    'height' => 500,
    'saveOptions' => ['quality' => 80]]
]
```

Crop the image to 500x500 pixel but start on 10,10 cordinates.

```php
[self::EFFECT_CROP, [
    'width' => 500, 
    'height' => 500,
    'start' => [10, 10]
    'saveOptions' => ['quality' => 80]]
]
```
