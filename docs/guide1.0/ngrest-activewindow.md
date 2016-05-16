# NgRest ActiveWindow

An *NgRest ActiveWindow* is a concept to attach a modal window into an [Ng Rest Crud List](app-admin-module-ngrest.md). The Active Window is always bound to an **ID** of an item and is represented as a button with an icon and/or an alias. 

An example of a Button in the crud list:

![button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide1.0/img/aw_button.png "Active Window Button")

An example of an active window (Change Password) when clicked:

![overlay-window](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide1.0/img/aw_window.png "Active Window Overlay")

> Use the [aw/create console command](luya-console.md) to generate a new Active Window.

### Example Window

A very example basic class with the name *TestActiveWindow* just renders an index and contains a callback:

```php
namespace mymodule\aws;

class TestActiveWindow extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'mymodule';
    
    public function index()
    {
        return $this->render("index");
    }
    
    public function callbackSayHello($name)
    {
        $this->sendSuccess('Hello: ' . $this->itemId);
    }
}
```

# Attaching the Active Window

> TBD translations

Um ein ActiveWindow einzubinden registerien Sie die Klasse im `aw` pointer mit der Funktion `load` innerhalb ihres ngrest config abschnittes. Da Active Windows über das yii\base\Object verfügen kannst du alle public eigenschaften des ActiveWindows beim load befehln überschreiben.

```php
public function ngRestConfig($config)
{
    // ...
    $config->aw->load(['class' => '\admin\aws\TestActiveWindow()', 'alias' => 'Mein Test Window', 'icon' => 'extension');
    // ...
    
    return $config;
}
```

* Ein *ActiveWindow* muss immer über eine `$module` property verfügen, diese dient dazu den Pfad für die view files ausfindig zu machen.
* Jedes *ActiveWindow* muss über eine `index()` methode verfügen.
* Callbacks müssen den prefix `callback` haben.

Um einen vordefinierten namen und icon deines Active Window zu vergeben, überschreibe die properties:

* $alias
* $icon

```php
public $alias = 'Das ist mein AW';

public $icon = 'extension';
```

> Pro Tipp: Du kannst andere *ActiveWindows* extenden (`extends XYZActiveWindow`) und die `$module` propertie anpassen um deine eigenen views zu rendern.

# View Files

> TBD translations

Das view file welches bei `$this->render('index')` gesucht wird würde im folgenden Ordner liegen `@admin/views/aws/testactivewindow` und der Datei names ist `index.php`.

Es gibt vordefinierte helper methoden aus dem view context welche zbsp. eine Button zur Verfügung stellen welcher direkt den Callback mit gewünschten optioen aufruft. Natürlich können auch angular resource files hinterlegt werden um komplexe tasks abzuwickeln.

Ein beispiel für den Inhalt des index views, der einen Knopf beinhaltet welchen die `callbackSayHello` methode aufruft:

```php
<h1>Window mit Button</h1>
<p>Beim klicken des Buttons sagen wir Hallo.</p>
<?= $this->callbackButton('Button Name', 'say-hello', ['params' => ['name' => 'Radan']]); ?>
```

### Angular in View files

As the administration interface is written in angular you can aso create inline Angular Controllers and interact with your Active Window class.

The below view file shows an Angular Controller which collectis data from the the controller assigned into the view, but uses ng-repeat to display and render the data.

```
<script>
zaa.bootstrap.register('InlineController', function($scope, $controller) {

	$scope.data = <?= $dataFromController; ?>;

	$scope.addToList = function(member) {
		$scope.$parent.sendActiveWindowCallback('add-to-list', {member:member}).then(function(response) {
			$scope.$parent.activeWindowReload();
		});
	};
});
</script>
<div class="row" ng-controller="InlineController">
	<ul>
		<li ng-click="addToList(member)" ng-repeat="item in data">{{item.name}}</li>
	</ul>
</div>
```

After the the Active Window response from function `addToList` has recieved, the active window well be reloaded. This is just a very quick integration example and does not give the user a true angular experience, but let you create solutions in a very quick time.

# Callback

> TBD translations

Wenn Sie die helper methoden wie `callbackButton()` verwenden im view, müssen Sie nach gewissen regeln spielen. Mit folgenden Funktionen können Sie der Helper methode mitteilen was innerhalb des Callbacks passiert ist:

+ `sendSuccess($message)` Gibt ein erfolg zurück mit einer Nachricht.
+ `sendError($message)` Gibt einen Fehler zurück mit einer Nachricht.

# Existing Reusable Active Windows

Gewisse Active Windows kannst du in deinem Projekte wieder verwenden und müssen nicht zusätzlich entwickelt werden. Hier eine Liste von ActiveWindows die du verwendest kannst und mit der Installtion der Admin ebene automatisch mit geliefert werden.

|Name   |Klasse |Public Properties
|--     |--     |--
|Tag    |`admin\aws\TagActiveWindow`|<ul><li>$tableName</li></ul>
|Gallery|`admin\aws\Gallery`|<ul><li>$refTableName</li><li>$imageIdFieldName</li><li>$refFieldName</li></ul>
|ChangePassword|`admin\aws\ChangePassword`|<ul><li>$className</li></ul>