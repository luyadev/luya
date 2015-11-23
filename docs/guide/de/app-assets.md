Projekt Assets
===============
Was sind Assets? *assets* sind Dateien welche zu deinem Projekt gehören. Dies können *Javascripts*, *Stylesheets* oder *Bilder* sein.

> Asset Dateien werden in der Regel in einem *resources*-Ordner hinterlegt um die *asset*-Klassen im `assets`-Ordner zu speichern.

Um eine *Asset*-Klasse anzulegen erstellen wir im Projekt den Ordner `assets`. Darin erstellen wir eine Datei (in unsere Beispiel LuyaioAsset) welche den Suffix *asset* haben muss.

```php
namespace app\assets;

class LuyaioAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $css = [
        "css/style.css",
    ];
}
```

Diese Projekt-Asset Klasse wird nun versuchen die Datei `css/style.css` im Ornder `app/resources` (also voll ausgeschrieben `app/resource/css/style.css`) aufzurufen sobald man diese Asset-Datei einbindet.

Asset Einbinden
---------------
Wenn du ein Luya-Projekt mit einem CMS im Einsatz hast **musst** du alle Asset-Daten dem *cms*-Modul melden.

> In der *luya-kickstater* Standard installation wird das CMS installiert und benutzt.

Um ein Asset zu melden gehst du in deine Konfigurations Datein und ergänzt den `modules` `cms` Eintrag um die `assets` Eigenschaft:

```php
return [
    'modules' => [
        'cms' => [
            'class' => 'cms\Module',
            'assets' => [
                '\\app\\assets\\LuyaioAsset',
                '\\app\\assets\\FooBarAsset',
            ]
        ],
    ]
];
```

Alternative könntest du auch Assets im php layout `views/layouts` registrieren.

```php
$luyaio = \app\assets\LuyaioAsset::register($this);
```

> Assets sollten wenn möglich **nicht** im *view* oder *layout* registriert werden.

Asset Verwenden
---------------
Wenn du ein Bild-Datei in einem Asset Ornder hinterlegst und den von Yii generierten Pfad zur Datei möchtest kannst wie folgt die URL deines Assets erhalten:

```php
$luyaio = $this->assetManager->getBundle('\\app\\assets\\LuyaioAsset');
```

Die Variabel `$luyaio` enthält nun das Asset-Objekt. Den Pfad zum Asset Ordner erhältst du mit

```php
echo $luyaio->baseUrl;
```

Die gleiche Problematik kann auch in Twig-Dateien gelöst werden:

```
{{ asset('\\app\\assets\\LuyaioAsset').baseUrl }}
```

> Wir empfehlen, Bild-Daten vom Layout in den `public_html`-Ordner zu speichern und nicht in das AssetBundle zu hinterlegen.

Assets Fehler
-------------
Assets werden einmalig in den ordern `assets` im `public_html` Ornder kopiert. Es empfiehlt sich also diesen Ordner zu löschen wenn ein Problem existiert.

> Wenn `YII_DEBUG` in der *config* auf `true` gesetzt ist, werden die Assets automatisch bei jedem Aufruf **neu erstellt**, dies verlangsamt das System, verhindert jedoch Problem beim entwickeln.