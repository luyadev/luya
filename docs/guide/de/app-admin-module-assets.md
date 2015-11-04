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

> Asset Daten sollten wie auch im Frontendkontext immer im Ordner `resources` hinterlegt werden.

Dieses Asset wird nun die Datei `calendar.js` im Ordner `@app/resources/` suchen.

### Einbinden des Assets
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
