Projekt Bower Assets
====================
Um häufig verwendet *assets* einzubinden (wie zbsp. JQuery, Bootstrap, etc.) kann man die Dateien via CDN einbinden, Downloaden und als *asset* einpflegen. Wenn nun aber eine neue Version dieser schnell lebenden Packete erscheint müssen diese ständig ersetzt werden. Ein elegantere möglichkeit dieses Problem zu lösen ist ein `bower asset`. [Bower](http://bower.io) ist ein packaging dienst die [Composer](https://getcomposer), jedoch für Asset Daten wie JavaScript und/oder Css.

Wir machen nun ein Beispiel wie Sie *JQuery* via Bower und Composer installieren können und ihr Luya integrieren.

Composer.json
-------------
Durch das globale initailisieren des `fxp/composer-asset-plugin` plugins bei der installation von *LUYA* kann nun gemäss [Anleitung](https://github.com/francoispluchino/composer-asset-plugin/blob/master/Resources/doc/index.md) ein Packet wie *JQuery* wie folgt in der `composer.json` hinterlegt werden:
```json
require : {
    "bower-asset/jquery" : "2.1.*@stable",
    "bower-asset/jquery-ui" : "1.*@stable"
}
```
Stellen Sie sicher das in Ihrer `composer.json` Datei auch das folgende Segement hinterlegt ist:
```json
"extra": {
    "asset-installer-paths": {
        "bower-asset-library": "vendor/bower"
    }
}
```

Bower im Asset verwenden
------------------------
Die *Asset Datei* untersheide sich nicht gross von den üblichen (Projekt Assets)[app-assets.md]. Der massgebende unterschied liegt im `$sourcePath` welcher nun auf das Bower Verzeichnis zielen soll:
```php
class JqueryAsset extends \luya\base\Asset
{
	public $sourcePath = '@bower';

	public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
    ];
}
```
Die `JqueryAsset` Datei lässt sich nun [wie üblich](app-assets.md) einbinden und verwenden.