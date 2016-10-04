Projekt Modul
=============
Ein Projekt Modul kann viele Aufgaben übernehmen. Es kann Datenbank-Logik über ein Model definieren und somit klarere Strukturen bei grossen Projekt schaffen. Ein Modul kann auch CMS-Blöcke zur Verfügung stellen. Es kann aber auch im Frontendbereich hilfreich sein um spezielle Darstellungen zu rendern. Somit sprechen wir von 2 verschiedenen Modul-Typen:

+ [Admin](app-admin-module.md) (Verwalten von Daten via Model)
+ [Frontend](app-module-frontend.md) (Rendern von views)

> Du kannst mit dem [Konsolenbefehl](app-console.md) `module/create` schnell und einfach ein Modul erstellen.

Einbinden
---------
Um ein Modul einzubinden öffnen Sie die aktuelle Konfiguration (`env-prep.php` oder `env-prod.php`) und erweitern den `modules` Abschnitt um ihr Modul:

```php
$config = [
    'modules' => [
        'contact'=> 'app\modules\team\Module'
    ]
];
``` 


Beispiel Modul
-------------
Wir werden nun in unserem Beispiel ein *Team-Modul* erstellen mit einem *Frontend-Modul* und einem *Admin-Modul*. Alle *Admin-Module* hat per definition ein suffix **admin**. Die benennung würde in unserem Beispiel wie folgt aussehen:
+ team *Frontend* `modules/team/Module.php`
+ teamadmin *Admin* `modules/teamadmin/Module.php`

Um ein neues Projekt-Modul anzulegen, erstellen Sie im Projekt-Verzeichnis einen Ordner `modules`. Darin wird der ein Ordner mit dem Modul-Namen erstellt `team`/`teamadmin`. Darin muss eine `Module.php` definiert.
Das *Frontend* Modul `modules/team/Module.php`:

```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{

}
```

Das *Admin* Modul `modules/teamadmin/Module.php`:

```php
<?php
namespace app\modules\teamadmin;

class Module extends \admin\base\Module
{

}
```


Import Methode
--------------
Module verfügen über eine `import(\luya\console\interfaces\ImportController $import)`. Wenn import ein array zurück gibt müssen dies Klassen-Namen sein welche von `\luya\base\Importer` extenden.

Beispiel für Klassen Response

```php
public function import(\luya\console\interfaces\ImportController $import)
{
    return [
        '\\cmsadmin\\importers\\BlockImporter',
        '\\cmsadmin\\importers\\CmslayoutImporter',
    ];
}
```

Beispiel für Code welcher direkt in der Methode ausgeführt wird und auf die $import variable zurück greift für helper funktionen und loggin mechanismus:

```php
public function import(\luya\console\interfaces\ImportController $import)
{
    foreach ($import->getDirectoryFiles('filters') as $file) {
        $filterClassName = $file['ns'];
        if (class_exists($filterClassName)) {
            $object = new $filterClassName();
            $import->addLog('filters', implode(", ", $object->save()));
        }
    }
}
```

Komponenten Registrieren
------------------------
TBD

Links
------
+ [Frontend Modul Anleitung](app-module-frontend.md)
+ [Admin Modul Anleitung](app-admin-module.md)