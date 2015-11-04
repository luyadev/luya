Frontend Modul Assets
=========================
Ein Modul kann vordefinierte Assets mitliefern und einbetten. Das kann von Vorteil sein wenn man z.B. komplexe Javascript Logik für ein Modul (wie z.B. Kalender) mitliefern möchte. Auch Stylesheets oder Bilddaten können als *Module Asset* mitgeliefert werden. Um solche externen Ressourcen einzubinden, erstellt man ein neues [Asset Bundle](app-assets.md) innerhalb des `assets` Ordner des entsprechenden Moduls, bzw. der Applikation.

### Asset-Bundle Datei
Ein Beispiel Asset Datei für *Javascript Kalender* Logik könnte wie folgt aussehen:

```php
<?php

namespace app\assets;

class JavascriptAsset extends \luya\web\Asset
{
    public $sourcePath = '@meinmodule/resources/';
    
    public $js = [
        "calendar.js"
    ];
}
```

> Asset Daten sollten immer im Ordner `resources` hinterlegt werden.

Dieses Asset wird nun die Datei `calendar.js` im Ordner `@meinmodule/resources/` suchen.

### Einbinden des Assets
Um die oben erstellte *Frontend Modul Asset* Datei einzubinden öffnen Sie die `Module.php` des Moduls welches Sie die Asset Datei darin erstellet haben und erweitern Sie in der `$assets` Array Eigenschaft/Property einen Eintrag des erstellten Assets.

```php
<?php
namespace app\modules\meinmodule;

class Module extends \luya\base\Module
{    
    public $assets = [
        'app\modules\meinmodule\JavascriptAsset'
    ];
}
```
