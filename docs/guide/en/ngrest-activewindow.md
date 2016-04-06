NgRest ActiveWindow
===================

> TO BE TRANSLATED

Ein *NgRest ActiveWindow* ist ein Fenster welches auf eine ID angeknüpft wird, dies zeigt sich als *Button* in der Grid übersicht deiner Datensätze. Du kannst nun auf den Knopf klicken und inhalt für diese aktuelle geklickt *ID* anzeigen. Ein *ActiveWindow" ist eine Klasse mit dem suffx *ActiveWindow* und befinden sich im Ordners `aws`.

Beim aufruven des *ActiveWindows* via den *Button* innerhalb der *Grid-Liste* wird als immer die `index()` methode gerendet.

Beispiel Klasse
------------------

So könnten ein *ActiveWindow* mit dem Namen *Test* aussehen.

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

View Files
-----------

Das view file welches bei `$this->render('index')` gesucht wird würde im folgenden Ordner liegen `@admin/views/aws/testactivewindow` und der Datei names ist `index.php`.

Es gibt vordefinierte helper methoden aus dem view context welche zbsp. eine Button zur Verfügung stellen welcher direkt den Callback mit gewünschten optioen aufruft. Natürlich können auch angular resource files hinterlegt werden um komplexe tasks abzuwickeln.

Ein beispiel für den Inhalt des index views, der einen Knopf beinhaltet welchen die `callbackSayHello` methode aufruft:

```php
<h1>Window mit Button</h1>
<p>Beim klicken des Buttons sagen wir Hallo.</p>
<?= $this->callbackButton('Button Name', 'say-hello', ['params' => ['name' => 'Radan']]); ?>
```

Die Callbacks
------------

Wenn Sie die helper methoden wie `callbackButton()` verwenden im view, müssen Sie nach gewissen regeln spielen. Mit folgenden Funktionen können Sie der Helper methode mitteilen was innerhalb des Callbacks passiert ist:

+ `sendSuccess($message)` Gibt ein erfolg zurück mit einer Nachricht.
+ `sendError($message)` Gibt einen Fehler zurück mit einer Nachricht.

In NgRest einbinden
--------------------

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

Vordefinierte Active Windows
----------------------------

Gewisse Active Windows kannst du in deinem Projekte wieder verwenden und müssen nicht zusätzlich entwickelt werden. Hier eine Liste von ActiveWindows die du verwendest kannst und mit der Installtion der Admin ebene automatisch mit geliefert werden.

|Name   |Klasse |Public Properties
|--     |--     |--
|Tag    |`admin\aws\TagActiveWindow` | <ul><li>$tableName</li></ul>
|Gallery|`admin\aws\Gallery` |<ul><li>$refTableName</li><li>$imageIdFieldName</li><li>$refFieldName</li></ul>