LUYA INSTALLATION
=================

1.
---
create a new composer.json

```
{
    "minimum-stability": "dev",
    "require": {
        "php": ">=5.4.0",
        "yiisoft/yii2": "2.0.*"
    },
    "config": {
        "process-timeout": 1800
    },
	"autoload" : {
		"psr-4" : {
			"luya\\" : "../luya/src/",
			"admin\\" : "../luya-modules/modules/admin/src",
			"cms\\" : "../luya-modules/modules/cms/src",
			"cmsadmin\\" : "../luya-modules/modules/cmsadmin/src"
		}
	}
}
```

2.

```
composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
```

3.
---

```
composer install
```

4.
---

Directory

application
application/assets (CHMOD 0777)
runtime (CHMOD 0777)
config
views
composer.json