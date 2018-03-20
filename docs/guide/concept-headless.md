# LUYA Headless system

As LUYA is built upon the concept of REST APIs, providing headless access to the database content of LUYA is a no brainer. You can either access the [[ngrest.md]] APIs or the CMS admin APIs. Since LUYA admin version 1.1.0 we've added the ability to create API-Users and an overview of which endpoints they can request data from:

![API User overview](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/api-user-overview.png "API User overview")

## Make calls

In order to make calls to the LUYA Admin APIs you can either use your own library or the [luya-headless client](github.com/luyadev/luya-headless) whicht provides a very easy to use wrapper. The headless client will be continuously developed in order to match the changing needs of a true headless system.

Example usage with the client library:

```php
use luya\headless\Client;

// bild client object with token and server infos
$client = new Client('API_TOKEN', 'http://localhost/luya-kickstarter/public_html/admin');

// create get request for `api-admin-lang` endpoint
$request = $client->getRequest()->setEndpoint('api-admin-lang')->get();

// if successfull request, iterate over language items from `api-admin-lang` endpoint
if ($request->isSuccess()) {
    foreach ($request->getParsedResponse() as $item) {
        var_dump($item);
    }
}
```

Using API wrappers (above example as short hand wrapper):

```php
use luya\headless\Client;
use luya\headless\endpoints\ApiAdminLang;

// bild client object with token and server infos
$client = new Client('API_TOKEN', 'http://localhost/luya-kickstarter/public_html/admin');

// run the pre-built ActivQuery for the `api-admin-lang` endpoint
foreach (ApiAdminLang::find()->all($client) as $item) {
    var_dump($item);
}
```

## Options

If you build a website with the LUYA CMS but use the headless client to render the content, you may want to configure the preview url to point to your headless page.

```php
'modules' => [
    'cmsadmin' => [
        'class' => 'luya\cms\admin\Module',
        'previewUrl' => 'https://mywebsite/preview/page',
    ],
]
```
