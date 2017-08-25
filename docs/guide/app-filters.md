# Image Filters

With *Filters* you can modify, crop, resize or use effects on any image provided from the storage component. To add a filter just create a filter class within the `filters` directory of your project or module and run the import command to add the filter into the system. When you change the effect chain of your filter you have to run the import command again in ordner to update all the images which are using your filter.

The basic concept behind filter classes, is to track filters in VCS system, so you can add a filter and push it into git, and your project members does have the same environement as you.

> Use the `./vendor/bin/luya admin/filter` command in order to generate a Filter quickly.

## Create a new filter

To create a filer file extended from the {{\luya\admin\base\Filter}} add a new file with the suffix `Filter` in your LUYA project root folder or module folder `filters` and run the import command.

```php
<?php

namespace app\filters;

class MyFilter extends \luya\admin\base\Filter
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

You can also chain several effects (behaviors) in the `chain()` method, by adding them as an array. So if you like to make a thumbnail and crop it afterwards your chain could look like this:

```php
public function chain()
{
    return [
        [self::EFFECT_THUMBNAIL, [
            'width' => 600,
            'height' => null,
            'mode' => \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET,
        ]],
        [self::EFFECT_CROP, [
            'width' => 400,
            'height' => 400,
        ]],
    ];
}
```

In order to read more about the differnt fileters and chain visit the [[app-filter-effects.md]] section.

As you can see the effect thumbnail use the Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET mode, this is as the filter image manipulation system is based on the [Imagine Library](https://github.com/avalanche123/Imagine).

## Using the Filters

You can apply filters directly inside the view scripts to an image. In our examples we have static image number *139* which would be id in the admin_storage_table and we use the above created filter identifier *my-filter*.

### apply filter in php view

An example of how to apply a filter in realtime to a retreived image:

```php
<img src="<?= yii::$app->storage->getImage(139)->applyFilter('my-filter')->source; ?>" border="0" />
```

Where *139* could be the image id from your database source active record. If you have casted a field with image() in your ngrest model you can access directly this variable:

```php
<? foreach($newsData as $item): ?>
    <img src="<?= yii::$app->storage->getImage($item['imageId'])->applyFilter(\app\filters\MyFilter::identifier())->source; ?>" border="0" />
<? endforeach; ?>
```

or you can use the filter name directly, this is less recommend as if the filter name changed you have to search trough out our whole project for the deprectated names.

```php
<? foreach($newsData as $item): ?>
    <img src="<?= yii::$app->storage->getImage($item['imageId'])->applyFilter('my-filter')->source; ?>" border="0" />
<? endforeach; ?>
```

the filter must be exact name like the method identifier() returns from the filter class.

> The {{luya\admin\image\Item::applyFilter}} returns the new generated {{\luya\admin\image\Item}} Object where you can access other methods and informations.
