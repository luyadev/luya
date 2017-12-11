# Image Filters

With *Filters* you can modify, crop, resize or use effects on any image provided from the storage component. To add a filter just create a filter class within the `filters` directory of your project root or module and run the import command to include the filter into the system. When you change the effect chain of your filter you have to run the import command again in order to update all the images which are using your filter.

The basic concept behind filter classes, is to track filters in VCS system, so you can add a filter and push it into git and your project members does have the same environment as you.

> Use the `./vendor/bin/luya admin/filter` command in order to generate a Filter quickly.

## Create a new filter

For creation of a filter extended from the {{\luya\admin\base\Filter}} add a new file with the filename suffix `Filter` in your LUYA project root folder or module folder `filters` and run the import command.

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

You can also chain several effects (behaviors) in the `chain()` method by adding them as an array. So if you like to make a thumbnail and crop it afterwards your chain could look like this:

```php
public function chain()
{
    return [
        [self::EFFECT_THUMBNAIL, [
            'width' => 600,
            'height' => null,
            'mode' => self::THUMBNAIL_MODE_INSET,
        ]],
        [self::EFFECT_CROP, [
            'width' => 400,
            'height' => 400,
        ]],
    ];
}
```

In order to read more about the different filters and chain visit the [[app-filter-effects.md]] section.

As you can see the effect thumbnail use the {{luya\admin\base\Filter::THUMBNAIL_MODE_INSET}} mode which is a the filter image manipulation system based on the [Imagine Library](https://github.com/avalanche123/Imagine).

## Using the Filters

You can apply filters directly inside the view scripts to an image. In our examples we have static image number **139** which would be the `id` in the admin_storage_table and we use the above created filter identifier **my-filter**.

### Apply filter in PHP view

An example of how to apply a filter in real`time to a retrieved image:

```php
<img src="<?= Yii::$app->storage->getImage(139)->applyFilter('my-filter')->source; ?>" border="0" />
```

Where **139** could be the image `id` from your database source active record. If you have a field with image() in your ngRest model you can access directly this variable:

```php
<? foreach($newsData as $item): ?>
    <img src="<?= Yii::$app->storage->getImage($item['imageId'])->applyFilter(\app\filters\MyFilter::identifier())->source; ?>" border="0" />
<? endforeach; ?>
```

or you can use the filter name directly which is not recommend as if the filter name change you have to search and replace trough the whole project for the deprecated names.

```php
<? foreach($newsData as $item): ?>
    <img src="<?= Yii::$app->storage->getImage($item['imageId'])->applyFilter('my-filter')->source; ?>" border="0" />
<? endforeach; ?>
```

The filter must be exact name like the method identifier() returns from the filter class.

> The {{luya\admin\image\Item::applyFilter}} returns the new generated {{\luya\admin\image\Item}} Object where you can access other methods and informations.
