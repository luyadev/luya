Image Filters
=======

> since `1.0.0-beta7` we use the [Yii2 Imagine Extension](https://github.com/yiisoft/yii2-imagine) which strongly improves the behavior of creating thumbnails by auto calculating values.

> since `1.0.0-beta8` filter `identifier()` method is a **static** method.

With *Filters* you can modify, crop, resize use effects on any image provided from the storage component. To add a filter just create a filter class within the `filters` directory of your project or module and run the import command to add the filter into the system. When you change the effect chain of your filter you have to run the import command again in ordner to update all the images which are using your filter.

The basic concept behind filter classes, is to track filters in VCS system, so you can add a filter and push it into git, and your project members does have the same environement as you.

Create a new filter
-----------------

To create a filter add a new file with the suffix `Filter` in your luya project root folder or module folder `filters` and run the import command.

```php
<?php

namespace app\filters;

class MyFilter extends \admin\base\Filter
{    
    public static function identifier()
    {
        return 'my-filter';
    }
    
    public function name()
    {
        return 'my App Filter';
    }
    
    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 100,
                'height' => 100,
            ]],
        ];
    }
}
```

You can chain several effects (behaviors) in the `chain()` method, by adding them as an array. So if you like to make a thumbnail and crop it afterwards your chain could look like this:

```php
public function chain()
{
    return [
        [self::EFFECT_THUMBNAIL, [
            'width' => 600,
            'height' => null,
        ]],
        [self::EFFECT_CROP, [
            'width' => 400,
            'height' => 400,
        ]],
    ];
}
```

[Read more about effects in the chain](app-filter-effects.md)

As you  can see the effect thumbnail usees the INSET Type, this is as the filter image manipulation system is based on [Imagine Libraray](http://imagine.readthedocs.org).

Using Filters
-------------

You can apply filters directly inside the view scripts to an image. In our examples we have static image number *139* which would be id in the admin_storage_table and we use the above created filter identifier *my-filter*.

### apply filter in php view

An example of how to apply a filter in realtime to a retreived image:

```php
<img src="<?= yii::$app->storage->getImage(139)->applyFilter('my-filter')->source; ?>" border="0" />
```

Where *139* could be the image id from your database source active record. If you have casted a field with image() in your ngrest model you can access directly this variable:

```php
<? foreach($newsData as $item): ?>
    <img src="<?= yii::$app->storage->getImage($item['imageId'])->applyFilter('my-filter')->source; ?>" border="0" />
<? endforeach; ?>
```

Since beta8 you can alos directly use the identifier method to apply filters:

```php
<? foreach($newsData as $item): ?>
    <img src="<?= yii::$app->storage->getImage($item['imageId'])->applyFilter(\app\filters\MyFilter::identifier())->source; ?>" border="0" />
<? endforeach; ?>
```

the filter must be exact name like the method identifier() returns from the filter class.

> The applyFilter returns the new genearted \admin\image\Item Object where you can access other methods and informations.


### apply filter in twig view

You can also use the twig filter to apply an image filter to an existing image. The ***main difference*** between the php and twig view is those, the twig filter only returns the http source to the newly applyd image instead of an image object.

```
<img src="{{ filterApply(139, 'my-filter') }}" />
```
