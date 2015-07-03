Projekt Modul
=============
Ein Projekt Modul kann viele Aufgaben übernehmen. Es kann Datenbank-Logik über ein Model definieren und somit klarere Strukturen bei grossen Projekt schaffen. Ein Modul kann auch CMS-Blöcke zur Verfügung stellen. Es kann aber auch im Frontendbereich hilfreich sein um spezielle Darstellungen zu rendern. Somit sprechen wir von 2 verschiedenen Modul-Typen:
+ [Admin](app-admin-module.md) (Verwalten von Daten via Model)
+ [Frontend](app-module-frontend.md) (Rendern von views)

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

Links
------
+ [Frontend Modul Anleitung](app-module-frontend.md)
+ [Admin Modul Anleitung](app-admin-module.md)