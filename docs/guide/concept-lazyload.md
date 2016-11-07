# Image Lazy Loading

In order to reduce server load and speed up page request LUYA is shipped with a built in LazyLoading Widget with a javascript which has no depencies to foreign bower data.

## How to use

```php
<?= LazyLoad::widget([
    'src' =>  $this->publicHtml . '/path/to/image',
    'width' => 'the-image-width-in-px',
    'height' => 'the-image-height-in-px',
    'extraClass' => 'custom-classes']); ?>
```

### Working with Background Images

```php
<?= LazyLoad::widget([
    'attributesOnly' => true,
    'src' =>  $this->publicHtml . '/path/to/image',
    'width' => 'the-image-width-in-px',
    'height' => 'the-image-height-in-px',
    'extraClass' => 'custom-classes']); ?>
```

## Using LazyLoader with Storage Component

Using the lazyloader with a storage component {{\luya\admin\image\Item}}:

```
$image = Yii::$app->storage->getImage(123);
<?= LazyLoad::widget([
    'src' => $image->source,
    'width' => $image->resolutionWidth,
    'height' => $image->resolutionHeight,
]) ?>
```