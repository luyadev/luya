Admin Permissions
====================

In order to set permissions for an API-Gateway or a custom Route you can add those informations into the `getMenu()` method function of the corresponding module and run the `import` command. LUYA admin will then create those permissiosn and you can allocate those in the groups and users settings.

Custom Menu-Route
-------------

```php
public function getMenu()
{
    return $this
    ->node("My Admin Module", "materialize-css-icon")
        ->group("Verwalten")
            ->itemRoute("Stats", "myadminmodule/stats/index", "materialize-css-icon")
            ->itemRoute("Export)", "myadminmodule/stats/export", "materialize-css-icon")
    ->menu();
}
```

Menu-Api
-------

```php
public function getMenu()
{
    return $this
    ->node('Administration', 'mdi-navigation-apps')
        ->group('Zugriff')
            ->itemApi('Benutzer', 'admin-user-index', 'mdi-action-account-circle', 'api-admin-user')
            ->itemApi('Gruppen', 'admin-group-index', 'mdi-action-account-child', 'api-admin-group')
        ->group('System')
            ->itemApi('Sprachen', 'admin-lang-index', 'mdi-action-language', 'api-admin-lang')
    ->menu();
}
```

Disable controller permissions
------------------------------------
Sie können innerhalb eines Controllers die Eigenschaft `disablePermissionCheck` auf `true` stellen um jeglich Prüfung von Berechtigungen **auszuschalten**, es wird jedoch geprüft ob eine Benutzer eingeloggt ist:

```php
class MyTestController extends \admin\base\Controller
{
    
    public $disablePermissionCheck = true;
    
    public function actionIndex()
    {
        // Diese Action kann von jedem Benutzer geöffnet werden, aber nicht einem Fremden-Gast der nicht in der Administration eingeloggt ist.
    }
}
```

Route und Api berechtigung ohne Menu
------------------------------------
Sie könne nauch *api* und *route* einträge erstellen ohne die `getMenu()` Funktion. Dazu gehen Sie in die `Module.php` und fügen wahlweise folgende methoden ein:

```php
public function extendPermissionApis()
{
    return [
        ['api' => 'api-cms-navitempageblockitem', 'alias' => 'Blöcke einfügen und verschieben'],
    ];
}

public function extendPermissionRoutes()
{
    return [
        ['route' => 'cmsadmin/page/create', 'alias' => 'Seiten erstellen'],
        ['route' => 'cmsadmin/page/update', 'alias' => 'Seiten bearbeiten'],
    ];
}
```

Interne berechtigungs berechnung
--------------------------------
Es gibt 3 zustände für die Berechtiung welche wie folgt berechnet werden:

| Name          | Wert
| ------        | ----
| crud_create   | 1
| crud_update   | 3
| crud_delete   | 5

Somit kommen beim addieren Dieser Werte folgende Zuständ zusammen

| create    | update    | delete    | Wert          | Beschreibung
| ---       | ---       | ---       | ---           | ----
| ☐         | ☐         | ☐         | 0             | Keine berechtigung
| ☑         | ☐         | ☐         | 1             | erstellen
| ☐         | ☑         | ☐         | 3             | bearbeiten
| ☑         | ☑         | ☐         | 4             | erstellen, bearbeiten
| ☐         | ☐         | ☑         | 5             | löschen
| ☑         | ☐         | ☑         | 6             | erstellen, löschen
| ☐         | ☑         | ☑         | 8             | bearbeiten, löschen
| ☑         | ☑         | ☑         | 9             | erstellen, bearbeiten, löschen

