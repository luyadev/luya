# API Endpoints

As APIs are the base concept of LUYA admin, you can modify and tweak them with a few changes in order to increase or customize the default behavior.

Every API endpoint must be extending from the {{luya\admin\ngrest\base\Api}} class and define the {{luya\admin\ngrest\base\Api::$modelClass}}. A very basic implementation could look like this:

```php
class MyEndpoint extends Api
{
    public $modelClass = 'app\models\MyModel';
}
```

## Join relations

Its very common to join relation data for index list view in order to reduce sql queries. To do so define the {{luya\admin\ngrest\base\Api::withRelations()}} method inside your API. This can be either an array with relations which will be passed to `index, list and view` or an array with a subdefintion in order to define which relation should be used when.

basic:

```php
public function withRelations()
{
    return ['user', 'images'];
}
```

The above relations will be auto added trough {{yii\db\ActiveQuery::with()}}. In order to define view specific actions:

```php
public function withRelations()
{
    return [
        'index' => ['user', 'images'],
        'list' => ['user'],
        'view' => ['images', 'files'],
    ];
}
```

## Pagination

The LUYA Api automaticcally enabled pagination after 200 rows, but you can also force this settings by configure the {{luya\admin\ngrest\base\Api::$pagination}} property:

```php
public $pagination = ['pageSize' => 50];
```

In order to enable the `per-page` get request option the `$pagination` property has to be declared like in the example above, by default you can then choose between 0 and 50 items. In order to configure the page size limit use:

```php
public $pagination = [
    'pageSize' => 50,
    'pageSizeLimit' => [0, 100]
];
```

## Extend index query

You can override the prepare index query to preload relation data with {{luya\admin\ngrest\base\Api::prepareIndexQuery()}} if you just have to load relations we recommend to use {{luya\admin\ngrest\base\Api::withRelations()}} instead.

```php
public function prepareIndexQuery()
{
    return parent::prepareIndexQuery()->joinWith(['relation1', 'relation2']);
}
```

Make sure to call the parent implementation!
