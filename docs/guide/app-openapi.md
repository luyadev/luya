# OpenAPI Generator

> WIP: This feature is still in Beta and only available when LUYA Admin Module 3.2 is installed.

Since version 3.2 of LUYA Admin Module an OpenAPI file generator is available. The generator creates a JSON OpenAPI Defintion based on all REST UrlRules and routes provided with ControllerMap.

The purpose of the generator is to have documentation where it should belong, in the code, but also provide those descriptions to the Endpoint Consumers.

![OpenAPI Custom Action](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/openapi-code-to-redoc.png "OpenAPI Custom Action")

## Enable OpenApi Endpoint

> To generate the OpenApi File the `cebe/php-openapi` composer package is required, install the library with `composer require cebe/php-openapi`.

In order to enable the OpenApi Endpoint you can either use `remoteToken` or ` publicOpenApi` property:

+ `remoteToken`: If a {{luya\web\Application::remoteToken}} is defined, the `?token=sha1($remoteToken)` param can be used to retrieve the OpenAPI defintion: `https://yourdomain.com/admin/api-admin-remote/openapi?token=8843d7f92416211de9ebb963ff4ce28125932878` (where token is an sha1 encoded value of remoteToken)
+ `publicOpenApi`: Enable {{luya\admin\Module::$publicOpenApi}} will expose the Endpoint `https://yourdomain.com/admin/api-admin-remote/openapi` to everyone, without any authentication or token.

When developer settings are enabled in User Profile (Preferences -> General -> Developer Mode), a new debug panel with OpenAPI informations is shown:

![OpenAPI Toolbar](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/debug-toolbar-openapi.png "OpenAPI Toolbar")

## ReDoc Viewer

When logged into the Admin Module, the Documentation can be explored in real time, either open the Developer Panel and click `Open Documentation Explorer` or enter `https://yourdomain.com/admin/default/api-doc`.

## PHP Documentation

The details, descriptions and paramters or mostly read from the PhpDoc blocks, this means documentation inside the code will be exposed to the Api Consumers, thefore its finally absolute worth to take time making propper documentations. This will make other developers, yourself and Api Consumers happy. The LUYA OpenAPI generator can interpret reference to objects and classes, will follow them and publish those to the OpenAPI.

An example of an LUYA Admin API Defintion:

```php
/**
 * Short Description.
 *
 * Long multi line description.
 * Long multi line description.
 * Long multi line description.
 */
class LangController extends Api
{
    public $modelClass = 'luya\admin\models\Lang';

    /**
     * This is a Test.
     *
     * Long Long Description
     * 
     * @param integer $id The id which is taken to find this element ...
     * @return \luya\admin\models\Group The group object to return.
     */
    public function actionTest($id)
    {

    }
}
```

The above {{luya\admin\ngrest\base\Api}} will be generate all the {{luya\rest\ActiveController}} actions like list, detail view, create, update and delete. The specifications will be taken from the ActiveRecord isntance defined in $modelClass (luya\admin\models\Lang in the above case).

The `actionTest()` requires an param `$id` and will return a {{luya\admin\models\Group}} instance defined in PHP Doc, therefore this is what would be rendered:

![OpenAPI Custom Action](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/openapi-custom-action.png "OpenAPI Custom Action")

When Parsing ActiveRecords the `@property` values of a class will be interpreted as well as `attributeLabels()` and `attributeHints()`.

## OpenAPI Client

In order to consum the OpenAPI trough OpenAPI Client you have to turn off {{luya\admin\Module::$jsonCruft}} behavior in the {{luya\Config}} for the Admin Module:

```php
 'admin' => [
    'class' => 'luya\admin\Module',
    'jsonCruft' => false,
    // ...
 ]
```

Currently test client generators:

+ https://github.com/janephp/janephp
