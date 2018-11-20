# Custom Admin API

If you want to create your own custom API without using the LUYA ngrest base API function, you only have to consider a few things. 

## API Controller File

Make sure to extend from `\luya\admin\base\RestController`.  
If you want to provide the default route, make sure to define the `actionIndex()` like this:

```
namespace app\modules\yourmodule\admin\apis;

class MyController extends \luya\admin\base\RestController
{
    public function actionIndex()
    {
    }
}
```

## Register the Api in Module

Define the endpoint in `$apis`in `Module.php` for the custom API like a normal ngrest API:
(assuming you're defining the API inside a module)

```
public $apis = [
  'api-yourmodule-yourcontroller' => 'app\modules\yourmodule\admin\apis\YourController'
];
```

If you want to use a custom route, define it in `$apiRules`. For example if you want to create a PUT request with a custom path to `yourFunction`:
```
public $apiRules = [
  'api-yourmodule-yourcontroller => [
    'extraPatterns' => [
      'PUT {yourvar}/your-function' => 'your-function',
    ]
  ],
];
```

## Make Request / How to access

Depending on your definition including your language code definition, your API should now be reachable under `http://host/yourlanguagecode/admin/api-yourmodule-yourcontroller`.

Dont forget to create an API user in admin and assign him the permission to access the API.
