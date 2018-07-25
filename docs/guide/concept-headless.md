# LUYA Headless system

As LUYA is built upon the concept of REST APIs, providing headless access to the database content of LUYA is a no brainer. You can either access the [[ngrest.md]] APIs or the CMS admin APIs. Since LUYA admin version 1.1.0 we've added the ability to create API-Users and an overview of which endpoints they can request data from:

![API User overview](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/api-user-overview.png "API User overview")

In order to see the API Users menu make sure to use luya-admin module in version ~1.1.0 and your group has all permissions.

## Make calls

**Read the [LUYA Headless client documentation](https://luya.io/packages/luyadev--luya-headless) in order to see how to make calls!**

To extend, improve or speed up your APIs, take a look at [[ngrest-api.md]] guide section.

## Additional Configuration

If you build a website with the LUYA CMS but use the headless client to render the content, you may want to configure the preview url to point to your headless page.

```php
'modules' => [
    'cmsadmin' => [
        'class' => 'luya\cms\admin\Module',
        'previewUrl' => 'https://mywebsite/preview/page',
    ],
]
```
