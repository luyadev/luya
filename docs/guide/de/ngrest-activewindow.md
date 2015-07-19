NgRest ActiveWindow
===================
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
    
    public function callbackSayhello($name)
    {
        return 'Hello ' . $name . ' from item: ' . $this->getItemId();
    }
}
```

* Ein *ActiveWindow* muss immer über eine `$module` property verfügen, diese dient dazu den Pfad für die view files ausfindig zu machen.
* Jedes *ActiveWindow* muss über eine `index()` methode verfügen.
* Callbacks müssen den prefix `callback` haben.

> Pro Tipp: Du kannst andere *ActiveWindows* extenden (`extends XYZActiveWindow`) und die `$module` propertie anpassen um deine eigenen views zu rendern.

View Files
-----------
@TODO
The render method from the example class above would try to find the view:

`@admin/views/aws/testactivewindow/index__`

Example content to interact with the callback `callbackSayhello` could be:

```
<h1>Hello ActiveWindow</h1>
<button type="button" ng-click="sendActiveWindowCallback('sayhello', { name : 'John Doe' })">Call the Callback</button>

<h3>RESPONSE:</h3>
<p>{{ activeWindowCallbackResponse }}</p>
```

Callbacks
----------
@TODO
After pushing the ***Call the Callback*** button, the activeWindowCallbackResponse variable would be filled with "Hello John Doe from item: 1", where the item id is the current selected element you have registered the ActiveWindow.

In NgRest einbinden
--------------------

```php
$config->aw->register(new \admin\aws\TestActiveWindow(), 'Mein Test Window');
```