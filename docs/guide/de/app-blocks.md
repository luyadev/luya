Projekt Blöcke
==============
Was sind Blöcke? Element die man im CMS-Modul in die *cmslayout*-Platzhalter hinein ziehen kann um neue Inhaltsabschnitte zu generieren. Bei der Installation von Luya lieferen wir eine vielzahl von benutzbaren Blöcke mit, wenn du aber speziel wünsche an dein Inhaltselement hast kannst du dies wiefolgt erstellen.
> Blöcke können auch als Inhaltselemnte bezeichnet werden.

Ein *Projekt-Block* muss in deinem Projekt-Ordner unter `blocks` hinzugefügt werden. Alle Block-Klassen sollten den Suffix `Block` haben. In unserem Beispiel erstellen wir einen TextTransform Block in diesem wir einen Eingabetext zu Grossbuchstaben umwandeln und in einem Paragraph Tag zurück gebe. Dieser Block würde also den Namen `TextTransformBlock` haben und im Verzeichniss `blocks` liegen.
> Blöcke können nur verwendet werden wenn *LUYA* das CMS-Modul installiert hat, dies ist bei der `luya-kickstarter` installation der Fall.

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

Block registrieren
------------------
Um einen Block welchen du erstellt hast zu registrieren gehen wir in das *Terminal* und wechseln in das `public_html` Verzeichnis deines Projekts. Dort geben wir den befehl ein:
```
php index.php exec/import
```
Dieser Befehl wird nun deinen neune Block in das System integrieren. Wenn ein Block nicht mehr existiert wird der `exec/import` ihn löschen. Wenn sich der Name der Klasse verändert hat wird das System ihn automatisch beim `exec/import` anpassen.

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
