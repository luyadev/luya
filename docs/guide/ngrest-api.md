# API Endpoints

As APIs are the base concept of LUYA admin, you can modify and tweak them with a few changes in order to increase or customize the default behavior.

Every API endpoint must be extending from the {{luya\admin\ngrest\base\Api}} class and define the {{luya\admin\ngrest\base\Api::$modelClass}}. A very basic implementation could look like this:

```php
class MyEndpoint extends Api
{
    public $modelClass = 'app\models\MyModel';
}
```

## Expand Relations

Its very common to join relation data for index list view in order to reduce sql queries. To do so define the {{luya\admin\ngrest\base\Api::withRelations()}} method inside your API. This can be either an array with relations which will be passed to `index, list and view` or an array with a subdefintion in order to define which relation should be used in which scenario.

```php
public function withRelations()
{
    return ['user', 'images'];
}
```

The above relations will be auto added trough {{yii\db\ActiveQuery::with()}} if defined in `?expand=user,images`. In order to define view specific actions:

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

The Yii Framework has a very convenient way to work with model sub relations, using [expand](https://www.yiiframework.com/doc/guide/2.0/en/rest-resources) can also "unfold" sub relations when defined in {{luya\admin\ngrest\base\NgRestModel::extraFields()}}.

```php
class XYZ extends NgRestModel
{
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
    public function extraFields()
    {
        return array_merge(['user'], parent::extraFields());
    }
}
```

> The {{luya\admin\ngrest\base\Api::withRelations()}} will **eager load** the data, but in order to expand sub relations e.g. `user.country` the country relation must be defined in {{luya\admin\ngrest\base\NgRestModel::extraFields()}} `array_merge(['country'], parent::extraFields())` inside the User model.

## Pagination

The LUYA API automaticcally enabled pagination after 200 rows, but you can also force this settings by configure the {{luya\admin\ngrest\base\Api::$pagination}} property:

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

You can override the prepare index query to preload relation data with {{luya\admin\ngrest\base\Api::prepareIndexQuery()}} if you just have to load relations we recommend to use {{luya\admin\ngrest\base\Api::withRelations()}} instead.

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

The APIs entry would be

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

Sometimes you need to have additional filtering methods for a given API requests, therefore {{yii\data\DataFilter}} is ussed. Assuming you'd like filter row for a given where condition, like groups you have to create a Filtering Model and declare the filter model in the API.

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

Now as you have declared the filtering model to the API, this allows you to use the `filter` param, assuming you d like to filter for a given group_id in the users lise there url would like this `my-api-filter?filter[group_id]=1`.

The filter can also be part of the requested body, the body param should then start with `filter` as well:

```json
{
    "filter": {"group_id":1}
}
```

Complex and nested conditions are possible as well:

```json
{
    "or": [
        {
            "and": [
                {
                    "name": "some name",
                },
                {
                    "price": "25",
                }
            ]
        },
        {
            "id": {"in": [2, 5, 9]},
            "price": {
                "gt": 10,
                "lt": 50
            }
        }
    ]
}
```

#### A few example as JSON and HTTP GET param

The following examples show filter requests for JSON body param or as get param. This helps to transform from JSON to HTTP GET param as its mostly harder to read and write.

<table>
<thead>
<tr>
<th>json</th>
<th>get</th>
</tr>
</thead>

<tr>
<td>
<code>
{
    "filter": {"group_id":{"in": [1,2,3]}
}
</code>
</td>
<td>
<code>
filter[group_id][in][0]=1&filter[group_id][in][1]=2&filter[group_id][in][2]=4
</code>
</td>
</tr>

<tr>
<td>
<code>
{
    "filter": {"group_id":{"gt":1}
}
</code>
</td>
<td>
<code>
filter[group_id][gt]=1
</code>
</td>
</tr>

<tr>
<td>
<code>
{
    "filter": {
        "or": [
            {"name":"John"},
            {"email":"john@doe.com"}
        ]
    }
}
</code>
</td>
<td>
<code>
filter[or][0][name]=John&filter[or][1][email]=john@doe.com
</code>
</td>
</tr>
</table>

> In order to decode and test a get url use `urldecode(http_build_query(['filter' => [/*...*/]))`
