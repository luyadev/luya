Export Data
===========

The exporter module allows you to easy download the full databse and storage data from a project to import them local. This allows you to setup a state of websites like it its.

### install

add to your composer.json

```
"luyadev/luya-module-exporter" : "1.0.0-beta5",
```

add the module to your application config:

```
'modules' => [
	// ...
	'exporter' => [
	    'class' => 'exporter\Module',
        'downloadPassword' => 'EnterYourSecureRandomToken',
	],
]
```

Now you can install a cronjob or run the command when doing deployment to prepare the download:

```sh
./vendor/bin/luya command exporter export
```

In order to download the above created files just go onto:

https://example.com/exporter?p=EnterYourSecureRandomToken and your zip will be downloaded.

> Attention, http sniffers can read your plain token.