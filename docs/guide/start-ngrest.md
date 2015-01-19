NGREST CLASS
============
1. What is NG-REST?
2. Setup new NG-REST
3. NG-Rest Config
4. Available Config Plugins
5. Straps (&Lifecycle)
6. Create your own Strap

What is NG-REST?
----------------
NG-Rest is the luya CRUD Configurator for REST APIS. Basicaly create the api and configure the crud (cread, read, update & delete) via the ng-rest configuration and you will get a fully functional Angular Crud Manager.

Setup new NG-REST
-----------------
First of all you have to create a Database Table, we assume to make a News Administration NG-REST Crud. 
1. Create your MySQL Table (Name: tbl_news)   
2. Create the Yii2 Model file. ({Module}/models/News.php)
```php
namespace {Module}\models;

use Yii;

class News extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'tbl_news';
	}

	public function rules()
	{
		return [
				[['title', 'userId', 'createDate', 'text'], 'required', 'on' => 'restcreate'],
				[['title', 'userId', 'updateDate', 'text'], 'required', 'on' => 'restupdate']
		];
	}

    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'userId', 'createDate', 'text'],
            'restupdate' => ['title', 'userId', 'updateDate', 'text']
        ];
    }
}
```
3. Create the API Endpoint class file. ({Module}/apis/NewsController.php)
```php
namespace {Module}\apis;

class NewsController extends \admin\base\RestActiveController
{   
    public $modelClass = '{Module}\models\News';
}
```
4. Let the Module ({Module}/Module.php) know you have Rest Api and make the Nodename inside of it:
```php
public $apis = [
        'api-news-news' => 'admin\apis\NewsController',
    ];
```
5. Create the NG-Rest Config
```php
	$config = new \luya\ngrest\Config('api-admin-user', 'id');

    $config->create->field("title", "Anrede")->select()->optionValue(\admin\models\User::getTitles());
	$config->create->field("firstname", "Vorname")->text()->required();
	$config->create->field("lastname", "Nachname")->text()->required();
	$config->create->field("email", "E-Mail-Adresse")->text()->required();
	$config->create->field("password", "Passwort")->password()->required();
    
    $config->list->copyFrom('create', ['password']);
	$config->update->copyFrom('create', ['password']);
	
    $ngrest = new \luya\ngrest\NgRest($config);
    
    return $ngrest->render(new \luya\ngrest\render\RenderCrud());
```

