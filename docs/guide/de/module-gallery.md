Gallery Module
===============

Gallery via Composer-Require beindung hinzufügen:

```
"zephir/luya-module-gallery" : "dev-master"
```

Um das Gallery Module einzufügen gibts du folgende konfiguration an:

```php
'gallery' => [
    'class' => 'gallery\Module',
],
'galleryadmin' => [
    'class' => 'galleryadmin\Module',
],
```