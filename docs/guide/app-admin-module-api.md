# Custom Admin API

If you want to create your own custom API without using the LUYA NgRest base API function, you only have to consider a few things. 

## API Controller File

Make sure to extend from `\luya\admin\base\RestController`. If you want to provide the default route, make sure to define the `actionIndex()` like this:

```php
namespace app\modules\yourmodule\admin\apis;

class MyController extends \luya\admin\base\RestController
{
    public function actionIndex()
    {
        return ['content' => 'foobar'];
    }
    
    public function actionHello()
    {
        return ['world'];
    }
}
```

## Register the API in Module

Define the endpoint in `$apis` property in `Module.php` for the custom API like a normal NgRest API: (assuming you're defining the API inside a module)

```php
public $apis = [
  'api-yourmodule-yourcontroller' => 'app\modules\yourmodule\admin\apis\YourController'
];
```

In order to make your API listen to differnt method types you can use $apiRules:

```php
public $apiRules = [
    'api-yourmodule-yourcontroller' => [
        'extraPatterns' => [
            'POST new-comment' => 'new-comment', // the action actionNewComment() which listens only to post
            'PUT update-comment' => 'update-comment', // the action actionUpdateComment() which listens only to put
        ]
    ],
];
```

An example of how to override the {{yii\rest\UrlRule}} patterns:

```php
public $apis = [
    'api-usertoken-login' => 'luya\admin\usertoken\apis\LoginController',
];

public $apiRules = [
    'api-usertoken-login' => [
        'patterns' => [
            'GET' => ' index',
        ]
    ],
];
```

Now the POST request will run the index action.

## Make Request / How to access

Depending on your definition including your language code definition, your API should now be reachable under `http://host/yourlanguagecode/admin/api-yourmodule-yourcontroller`. In order to access the actionWorld use `http://host/yourlanguagecode/admin/api-yourmodule-yourcontroller/hello`.
