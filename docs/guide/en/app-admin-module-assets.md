Admin-Modul Assets
==================

Möchte man im Admin Kontext externe Ressourcen verwenden, können diese ähnlich zum Frontend Kontext über ein Assetbundle eingebunden werden. Da es sehr wahrscheinlich ist, dass man dazu die Werkzeuge benötigt (Angular mit allen bereits definierten Direktiven, Bower, Jquery, etc.), sollte man unbedingt das `Main` Bundle als Abhängigkeit mit einbinden:

### Asset-Bundle Datei mit den grundlegenden Abhängigkeiten

Als Beispiel wird ein Javascript Asset eingebunden:

```php
<?php

namespace app\assets;

class CalendarAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';

    public $js = [
        'js/calendar.js',
    ];

    // important to solve all javascript dependency issues relating jquery, bower, angular, ...
    public $depends = [
        'admin\assets\Main',
    ];
}
```

> Asset Daten sollten, wie auch im Frontendkontext, immer im Ordner `resources` hinterlegt werden.

Dieses Asset wird nun die Datei `calendar.js` im Ordner `@app/resources/` suchen.

### Einbinden der Assets in Module.php
Um die oben erstellte `Calendar` *Admin Modul Asset* Datei einzubinden, wird die `Module.php` der Applikation bzw. des Moduls im `$assets` Array um einen Eintrag erweitert.

```php
<?php
namespace app\modules\meinmodule;

class Module extends \admin\base\Module
{
    public $assets = [
        'app\assets\CalendarAsset'
    ];

}
```

### Assets in einem Modul einbinden

Ähnlich zu der Einbindung im Applikationskontext, wird das Verzeichnis `assets` unter dem entsprechenden Modul angelegt und die Asset-Klasse abgeleitet:

 ```
 <?php

 namespace app\modules\examplemodule\assets;

 class MyAsset extends \luya\web\Asset
 {
     public $sourcePath = '@examplemodule/resources';

     public $js = [
         'js/myscript.js',
     ];

     public $css = [
         'css/mycss.css',
     ];

     public $depends = [
         'admin\assets\Main',
     ];
 }
 ```

Die Einbindung in `Module.php` im jeweiligen Modul erfolgt analog dem oberen Beispiel unter `Einbinden der Assets in Module.php`.