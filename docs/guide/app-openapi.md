# OpenAPI Generator

> WIP!

> This feature is still in Beta and only available when LUYA Admin Module is installed.

Since version 3.2 of LUYA Admin Module and OpenAPI file generator is available. The generator creates a JSON OpenAPI Defintion based on all REST UrlRules and routes provided with ControllerMap.

## Enable OpenApi Endpoint

In order to enable the OpenApi Endpoint you can either use `remoteToken` or ` publicOpenApi` property:

+ `remoteToken`: If a {{luya\web\Application::remoteToken}} is defined, the `?token=sha1($remoteToken)` param can be used to retrieve the OpenAPI defintion: `https://yourdomain.com/admin/api-admin-remote/openapi?token=8843d7f92416211de9ebb963ff4ce28125932878` (where token is an sha1 encoded value of remoteToken)
+ `publicOpenApi`: Enable {{luya\admin\Module::$publicOpenApi}} will expose the Endpoint `https://yourdomain.com/admin/api-admin-remote/openapi` to everyone, without any authentication or token.

When developer settings are enabled in User Profile (Preferences -> General -> Developer Mode), a new debug panel with OpenAPI informations is shown:

[[[SCREENSHOT DEBUG TOOLBAR]]]

