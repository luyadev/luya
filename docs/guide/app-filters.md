FILTERS
=======

Create your custom filters which will be imported during exec/import

```php
<?php

namespace app\filters;

class MyFilter extends \admin\base\Filter
{    
    public function identifier()
    {
        return 'small-thumbnail';
    }
    
    public function name()
    {
        return 'kleines Thumbnail';
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