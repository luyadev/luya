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
public $pagination = ['defaultPageSize' => 50];
```

In order to enable the `per-page` get request option the `$pagination` property has to be declared like in the example above, by default you can then choose between 0 and 50 items. In order to configure the page size limit use:

```php
public $pagination = [
    'defaultPageSize' => 50,
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

## Extra Url Rules

Since core 1.0.10 and admin 1.2.2 you can also provide some extra patterns for your APIs. With the configuration of {{luya\base\Module::$apiRules}} you can give every API a customized setup. As the rules are defined trough {{yii\rest\UrlRule}} you can now set extra pattern, exclude given actions or change tokens.

An example of adding a semantic get request action could look like this:

```php
class NewsController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'app\models\News';
    
    public function actionComments($id)
    {
        // return comments for given id
    }
}
```

The apis entry would be

```php
public $apis = [
    'api-module-news' => 'app\modules\admin\apis\NewsController',
];
```

In the traditional way you would have to run the action `actionComments` like following `example.com/admin/api-module-news/comments?id=1` but as you want to unfold the comments with `example.com/admin/api-module-news/1/comments` you can now add this rule to the extra pattersn for the rule defintion:

```php
 public $apiRules = [
    'api-module-news' => ['extraPatterns' => ['GET {id}/comments' => 'comments']]
];
```

## Filtering

Sometimes you need to have additional filtering methods for a given API requests. Assuming you'd like filter row for a given where condition, like groups you have to create a Filtering Model and declare the filter model in the API.

Define the filter model:

```php
class MyApiFilter extends \yii\base\Model
{
    public $group_id;
    
    public function rules()
    {
        return [
            [['group_id'], 'integer'],
        ];
    }
}
```

Assigne the filter model to the API:

```php
class MyApi extends luya\admin\ngrest\base\Api
{
    public $modelClass = 'app\models\Users';
     
    public $filterSearchModelClass = 'app\models\MyApiFilter';
}
```

Now as you have declared the filtering model to the api, this allows you to use the `filter` param, assuming you d like to filter for a given group_id in the users lise there url would like this `my-api-filter?filter[group_id]=1`.