FILTERS
=======

Create new Filter
-----------------

Create your custom filters which will be imported during exec/import

```php
<?php

namespace app\filters;

class MyFilter extends \admin\base\Filter
{    
    public function identifier()
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

the avilable effects to chain are listed in admin-effects.md

Using Filters
-------------

You can apply filters directly inside the view scripts to an image. In our examples we have static image number _139_ which would be id in the admin_storage_table and we use the above created filter identifier _my-filter_.

***PHP VIEW***

The below example show you how to use the filter directly inside of a php view file:
```php
<img src="<?= yii::$app->luya->storage->image->filterApply(139, 'my-filter')->source; ?>" border="0" />
```
where 139 is the fileId. This data is usual provided from the database. If you have casted a field with image() in your ngrest model you can access directly this variable:
```php
<? foreach($newsData as $item): ?>
	<img src="<?= yii::$app->luya->storage->image->filterApply($item['imageId'], 'my-filter')->source; ?>" border="0" />
<? endforeach; ?>
```

the filter must be exact name like the method identifier() returns from the filter class.

***TWIG VIEW***

You can also use the twig filter to apply an image filter to an existing image. The ***main difference*** between the php and twig view is those, the twig filter only returns the http source to the newly applyd image.
```
<img src="{{ filterApply(139, 'my-filter') }}" />
```