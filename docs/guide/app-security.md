# Security

A few tricks to increase the security of your application in production environment:

+ {{luya\web\Composition::$allowedHosts}} Configure this property inside the composition component in order to prevent dns wildcard hijacking.
+ {{luya\traits\ApplicationTrait::$ensureSecureConnection}} You should always enable https in order to prevent Man in the middle attacks and you should enable this in your htaccess or via webserver, but you can also, as a fallback, enable this setting in order to ensure secure connection on application level.
