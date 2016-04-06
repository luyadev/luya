Admin Modul NgRest CRUD
=======================

One of the most powerfull tools in *LUYA*, is the **ANGULAR CRUD** surface, its combines *Angular*, *RESTful*, *CRUD* and *Active Record* in a very elegant and powerfull way. So in a more understable sentence "Generate formulars to create, update, delete and list your data very fast and elegant*. It creates and API you can talk trough Angular and you can configure it like an ActiveRecord, and also use it like an Active Record Model.

The word *NgRest* is explained as follows: A**Ng**ular**Rest** (Representational State Transfer)

> In order to create your own *NgRest* quickly and not understanding the details under the hood, you can create a migration with your data table, create an admin module and the run `./vendor/bin/luya crud/create`.

#### Steps to understand and create an NgRest Crud

Preparations
* [Create database table via migrations](luya-console.md)
* [Create an Admin Module](app-admin-module.md) where you can put the NgRest Crud files.

1. Create the base model class (combination of Active Record and NgRest Crud defintion) which is used for the api and the controllers
2. Create the Controller and the Api
3. Define and Add the Api-Endpoint to your Module and enable the Authorizations
4. Import and Setup privileges.

> TO BE TRANSLATED

## 1. The Model

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

Eine detaillierte Erkärung der `ngRestConfig() Methode finden Sie in der [NgRest Sektion](ngrest.md).

## 2. Controller and API

### NgRest Controller

Um die CRUD Logik anzuzeigen, müssen wir einen Controller anlegen, welcher auf das *Model* verweist:

```php
<?php
namespace teamadmin\controllers;

class MemberController extends \admin\ngrest\base\Controller
{
    public $modelClass = 'teamadmin\models\Member';
}
```

### NgRest Api

TBD: Warum NgRest Api?

```php
<?php
namespace news\apis;

class MemberController extends \admin\ngrest\base\Api
{
    public $modelClass = 'teamadmin\models\Member';
}

```

## 3. Api-Endpoint

### Endpoint

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

### Menu
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
## 4. Import and Priviliges

run `./vendor/bin/luya import`, open the administration area and allocated the new menu items to a group.
