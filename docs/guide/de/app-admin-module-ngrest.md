Admin Modul NgRest CRUD
=======================
Eines der Kernbestandteile von *LUYA* liegt darin in kurzer Zeit eine mächtige Administrations Oberfläche zu erstellen auch NgRest CRUD genannt. Ein CRUD beinhaltet *create (erstellen)*, *read (lesen)*, *update (aktualisieren)* und *delete (löschen)* also alle nötigen Methoden, um eine Datenbank Tabelle zu aktualisieren. Das Wort NgRest besteht aus A**Ng**ular**Rest** (Representational State Transfer), weil die gesamt *LUYA* Adminoberfläch wie REST ansprechbar ist und durch das extrem starke Angular Javascript Framework angesprochen wird. Um einen NgRest Oberfläch zu erstellen benötigen wir folgendes:

+ [Migration Tabelle](luya-console.md#migration)
+ Einen Api-Endpoint Eintrag im Modul
+ Ein Model
+ Einen Controller
+ Einen API-Controler
+ Einen Menu Eintrag im Modul

> Sie können mit dem [Konsolenbefehl](luya-console.md) `crud/create` sämtliche Dateien generieren. Es empfiehlt sich jedoch die einzelnen Punkte zu verstehen.

NgRest Api-Endpoint
-----------------
Öffnen Sie die `Module.php` in dem Module, in dem sie die *NgRest* Oberfläche initialisieren möchten und fügen Sie die Eigenschaft `public $apis` ein. Tragen Sie nun einen **Api-Endpoint** für Ihre Schnittstelle ein wobei der Key dem späteren Link zur Schnittstelle und Value der ApiController Klasse enspricht.  

```php
<?php
namespace teamadmin;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-team-member' => 'teamadmin\\apis\\MemberController',
    ];
}
```

Ein Api-Endpoint besteht immer aus *api-{module}-{model}* wobei beim *module* immer das **Frontend-Module** gewählt wird.

> Api-Endpoints haben **nie** das Admin Prefix, da es in diesem Kontext keinen Sinn ergäbe. Technisch gesehen kann man jedoch jeglich Text als Api-Endpoint hinterlegen.

Alle Apis werden **singular** ausgedrückt (wie Datenbank Tabellen), also **member** und nicht  ~~members~~ .

NgRest Model
-----------------
Nachdem Sie eine Datenbank Tabelle via [Migration](luya-console.md) erstellt haben, können Sie ein *ActiveRecord* Model erstellen im Ordner `models` mit dem Namen der Tabelle:

```php
<?php
namespace teamadmin\models;

class Member extends \admin\ngrest\base\Model
{
    public static function tableName()
    {
        return 'teamadmin_member';
    }
    
    public function rules()
    {
        return [
            [['name', 'title', 'text'], 'required']
        ];
    }
    
    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'title', 'text'],
            'restupdate' => ['name', 'title', 'text'],
        ];
    }
    
    /* ng-rest method config */
    
    public $ngRestEndpoint = 'api-team-member';
    
    public function ngRestConfig($config) 
    {
        $config->list->field("name", "Name")->text();
        $config->list->field("title", "Titel")->text();
        $config->list->field("text", "Text")->textarea();
        
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        
        return $config;
    }
    
}
```

Eine detaillierte Erkärung der `ngRestConfig() Methode finden Sie in der [NgRest Sektion](ng-rest.md).

NgRest Controller
-----------------
Um die CRUD Logik anzuzeigen, müssen wir einen Controller anlegen, welcher auf das *Model* verweist:

```php
<?php
namespace teamadmin\controllers;

class MemberController extends \admin\ngrest\base\Controller
{
    public $modelClass = 'teamadmin\models\Member';
}
```

NgRest Api
----------
TBD: Warum NgRest Api?

```php
<?php
namespace news\apis;

class MemberController extends \admin\ngrest\base\Api
{
    public $modelClass = 'teamadmin\models\Member';
}

```

NgRest Menu Eintrag
--------------------
Fügen Sie nun die `getMenu()` Funktion in Ihre `Module.php` ein, um die Menu Einträge zu erstellen und die 
[Berechtigungen](app-admin-module-permission.md) zu setzen:

```php
public function getMenu()
{
    return $this
    ->node("Team Admin", "fa-wrench")
        ->group("Verwalten")
            ->itemApi("Mitglieder/Members", "teamadmin-member-index", "fa-ils", "api-teamadmin-member")
    ->menu();
}
```
