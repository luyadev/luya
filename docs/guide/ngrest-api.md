# API Endpoints

As APIs are the base concept of LUYA admin, you can modify and tweak them with a few changes in order to increase or customize the default behavior.

Every API endpoint must be extending from the {{luya\admin\ngrest\base\Api}} class and define the {{luya\admin\ngrest\base\Api::$modelClass}}. A very basic implementation could look like this:

```php
class MyEndpoint extends Api
{
    public $modelClass = 'app\modles\MyModel';
}
```

## Join relations

This can be either an array with relations which will be passed to `index, list and view` or an array with a subdefintion in order to define
     * which relation should be us when.
     * 
     * basic:
     * 
     * ```php
     * return ['user', 'images'];
     * ```
     * 
     * The above relations will be auto added trough {{yii\db\ActiveQuery::with()}}. In order to define view specific actions:
     * 
     * ```php
     * return [
     *     'index' => ['user', 'images'],
     *     'list' => ['user'],
     *     'view' => ['images', 'files'],
     * ];
     * ```

## Pagination

```php
public $pagination = ['pageSize' => 100];
```

## Extend index query

You can override the prepare index query to preload relation data like this:
     *
     * ```php
     * public function prepareIndexQuery()
     * {
     *     return parent::prepareIndexQuery()->joinWith(['relation1', 'relation2']);
     * }
     * ```
     *
     * Make sure to call the parent implementation!
