Projekt Blöcke
==============

> Benutze `./vendor/bin/luya block/create` um einen block zu erstellen.

Was sind Blöcke (oder auch als Inhaltselemente bezeichnet)? Element die man im CMS-Modul in die *cmslayout*-Platzhalter hinein ziehen kann um neue Inhaltsabschnitte zu generieren. Bei der Installation von Luya lieferen wir eine vielzahl von benutzbaren Blöcke mit, wenn du aber speziel wünsche an dein Inhaltselement hast kannst du dies wiefolgt erstellen.

Ein *Projekt-Block* muss in deinem Projekt-Ordner unter `blocks` hinzugefügt werden. Alle Block-Klassen sollten den Suffix `Block` haben. In unserem Beispiel erstellen wir einen TextTransform Block in diesem wir einen Eingabetext zu Grossbuchstaben umwandeln und in einem Paragraph Tag zurück gebe. Dieser Block würde also den Namen `TextTransformBlock` haben und im Verzeichniss `blocks` liegen.

> Blöcke können nur verwendet werden wenn *LUYA* das CMS-Modul installiert hat, dies ist bei der `luya-kickstarter` installation der Fall.

Wenn du das Prinzip und den Aufbau eines Blockes verstanden hast, kannst du bequem im Terminal mit dem [Konsolenbefehl](luya-console.md) `block/create` über einem Wizzard, Blöcke in dein Module oder Projekt erstellen.

Beispiel Block
--------------
Ein einfacher Text-Block welcher die Eingabe in Uppercase und Original ausgibt:

```php
<?php
namespace app\blocks;

class TextTransformBlock extends \cmsadmin\base\Block
{
    public function icon()
    {
        return 'mdi-action'; // Icons unter: http://materializecss.com/icons.html
    }
    
    public function name()
    {
        return 'Textabsatz Transformiert';
    }
    
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'mytext', 'label' => 'Meine Text', 'type' => 'zaa-text'],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'textTransformed' => strtoupper($this->getVarValue('mytext')),
        ];
    }
    
    public function twigFrontend()
    {
        return '<p>Original Eingabe: {{vars.mytext}}</p><p>Eingabe in Uppercase: {{extras.textTransformed}}';
    }

    public function twigAdmin()
    {
        return 'Administrations-Ansicht: {{ vars.mytext }}';
    }
}
```

> Anstelle eines Zusammengsetzten Strings für die Rückgabe der TwigFrontend-Datei kannst du auch die Methode `$this->render()` verwenden. Die Render funktione wird gemäss eine Konvention nach einem Twig File im views Ordner des modules suchen.

> Pro Tipp: Wenn du einen Block hast welcher als Platzhalter agiert, und keine Admin View representation benötgit solltest du `public $isContainer = true` anschalten, um eine Optische hervorhebung zu erhalten.

Block registrieren
------------------
Um einen Block welchen du erstellt hast zu registrieren gehen wir in das *Terminal* und wechseln in das Projekt Verzeichniss. Dort geben wir den befehl ein:

```sh
./vendor/bin/luya import
```

Dieser Befehl wird nun deinen neune Block in das System integrieren. Wenn ein Block nicht mehr existiert wird der `import` ihn löschen. Wenn sich der Name der Klasse verändert hat wird das System ihn automatisch beim `import` anpassen.

Module Blöcke
--------------
Wenn du einen Block in einem *Modul* (@TODO->go to module) erstellts also zbsp. `mymodule/blocks/TestBlock` dann musst du deinem Block mitteilen wo er das render file suchen muss wenn du die `$this->render()` methoden aufrufst. Um deinem Block mitzuteilen wo er suche muss fügst die Klassen-Eigeschanft `public $module` ein oder überschreibst den Wert mit `public function getModule();`.

```php
class TestBlock extends \cmsadmin\base\Block
{
    public $module = 'mymodule';
}
```

Methoden Erklärung
------------------
Diese Übersicht erklärt die Methoden/Funktionen welche implenetiert werden müssen.

| Name | Return | Beschreibung
| ---- | --------| ------------
| icon | string | Kann ein [Materialize-Icon](http://materializecss.com/icons.html) zurück geben.
| name | string | Gibt den Namen des Blockes zurück.
| config | array | Hier kannst du deine Eingaben Konfigurieren wobei dir die folgenden array keys zur verüfung stehen ´vars´, ´cfgs´ und ´placeholders´. Einzelen Array Element werden HIER(@TODO) erklärt.
| extraVars | array | Wenn du zusätzliche Variablen benötigst welche durch den Benutzer input verabteitet werden oder gar nicht als eingabe variable zur verfügung stehen sollte kannst du dieser hier definiere und in the Twig-Views unter `extras.VARIABEL´ abgreifen.
| twigFrontend | string | Dieser Twig-View wird im Frontend gerendert und somit für den Endbenutzer ersichtlich. [Twig Syntaxe](http://twig.sensiolabs.org/)
| twigAdmin | string | Dieser Twig.js-View wird im Administrationbereich des CMS gerendet, also für die Benutzer der Block-Elemente Oberfläche [Twig.js Syntaxe](https://github.com/justjohn/twig.js/wiki)

Caching
-------

> seit 1.0.0-beta2

Blöcke können im Frontend Context gecached werden und somit die ausführzeit drastisch verkürzern. Damit das caching funktioniert muss in der konfigurations datei eine cache [komponente hinterlegt](http://www.yiiframework.com/doc-2.0/guide-caching-data.html#cache-components) werden.

Wenn du einen neune block erstellst ist das caching standardmässig *ausgeschaltet* um es zu aktivieren stelle die eigenschaft `cacheEnabled` auf true:

```php
class MyTestBlock extends \cmsadmin\base\Block
{
    public $cacheEnabled = true;
}
```

standard mässig beträgt die cache zeit für einen block eine Stunde. Um die caching Zeit zu verstellen kannst du die eigenschaft `cacheExpiration` auf einen bliebeigen integer Wert umstellen. Die Zeitangabe ist in Sekunden, also 3600 entspricht einer Stunde und 60 einer Minute.

```php
public $cacheExpiration = 60;
```

> Der standard wert von $cacheExpiration beträgt 3600

Env Optionen
------------
Ein Block wird in einer bestimmten Umgebung (*Environemnt* kurz *Env*) aufgerufen. Diese Umgebungs-Inhalt stehe dir via

```php
$this->getEnvOption($key, $defaultValue);
```

zur Verfügung. Es stehen dir folgende Env keys zur Verfügung

+ *id* Ist der unique-identifier innerhalb des cms context
+ *blockId* Enthält die Id des Blocks in der Datenbank
+ *context* Sagt dir ob der Block im *frontend* oder *backend* aktiv ist
+ *pageObject* Gibt ein `cmsadmin\models\NavItem` Object zurück (nav_item), dies wiederum verfügt über die methode `getNav()` welches das `cmsadmin\models\Nav` Object zurück gibt.

#### Property / Eigenschaft

Eine bestimmten Eigenschaft (property) abfragen:

```php
$propObject = $this->getEnvOption('pageObject')->getNav()->getProperty('myCustomProperty');
```

Wenn die Eigenschaft gefunden wurde erhälts du ein Objekt, um auf den Benutzer eingabe/auswahl Wert zuzugereiffen kannst du die eigenschaft `$value` ausgeben.

```php
echo $propObject->value;
```

> Wenn die Property nicht gefunden wurde gibt die Funktion `false` zurück.

Assets registrieren
-------------------

> since *1.0.0-beta1*

Blöcke können neu [Assets (CSS&JS)](app-assets.md) registerien. Dazu musst du lediglich die `public $assets = []` probiert mit deiner gewünschten asset klasse überschreiben. Ein Beispiel innerhalb deines könnten wie folgt aussehen:

```php
class TestBlock extends \cmsadmin\base\Block
{
    public $assets = [
        'apps\assets\TestBlockAsset',
        'apps\assets\TestBlockZweitesAsset',
    ];
}
```

Die [Assets](app-assets.md) werden nur im *frontend* context geladen, heisst wenn der Block im Cms eingebunden ist und auf Seite angezeigt wird und funktioniert **nicht im admin** bereich.

Ajax in Blöcken
---------------

> since *1.0.0-beta1*

Damit blöcke via Ajax sich selber aufrufen können und methoden ausführen gibt es folgendes konzept

+ `createAjaxLink()`: Erstellt einen Link welcher im twigFrontend verwendet werden kann und zu einem *callback* führt.
+ `callback...()`: Methoden die mit *callback* prefixed sind können von öffentlich (ajax) aufgerufen werden.

Zuerst definiern wir eine methode (callback) welche durch den Ajax aufruf daten zurück gibt (kann json, oder den direkten html response sein). Alle callback methoden **müssen** mit `callback` beginen und danach mit (Upper)CamelCase fortfahren.

```php
public function callbackHelloWorld($zeit)
{
    return 'hallo world ' . $zeit;
}
```

Dieser oben genannte callback mit dem Parameter `$zeit` muss nun von einem Javascript ajax aufrufen (welcher in der asset datei liegen sollte) aufgerufen werden. Den Link zu diesem callback wird mit der Funktion `createAjaxLink` erzeugt. Das erzeugen des Links für den `callbackHelloWorld` würde wie folgt aussehen.

```php
$this->createAjaxLink('HellWorld', ['zeit' => time()]);
```

Der erzeugte Link sollte direkt im `extraVars()` eingbunden werden und kann danach an die funktione assigned werden welche den ajax aufruft macht.

### Parameter im Callback

Ein wichtiges thema sind die Paramter inerhalb dieser Callbacks. Wenn ein callback erforderliche paramter erzwingt (wie zbsp. im obige Beispiel `$zeit`), müssen diese auch im createLink zur verfügung gestellt werden. Ansonsten wird eine Exception den ajax call abbrechen. Wenn Sie zusätlich Daten via ajax übermitteln wollen, sollten Sie diese via POST methode senden und im callback via `Yii::$app->request->post()` abrufen.
