Frontend Modul
==============
Ein *Frontend* Modul kann direkt views rendern und daten aus modellen ausgeben. Um ein Modul aufzurufen öffnen sprechen Sie das Module im Browser direkt mit deren namen an `http://localhost/meinprojekt/meinmodul` oder wenn man sich im CMS Context bewegt ein Module-Block hinzufügen.

View Render Einstellungen
-------------------------
Ein Modul kann via `$useAppLayoutPath` entscheiden ob alle views *isoliert* im Modul liegen sollen oder alle views im Views Ordner des Projekts liegen sollen also *shared*. Die isolierte Methode kann verwendet werden wenn ein Modul die komplette kontrolle und unabhängig eines Projekts verwendet werden soll. Alle Daten werden somit gelifert und der Benutzer muss keine Zeit in tempaltes mehr investieren. Dies kann zum Beispiel bei einer komplexen Kalender ansicht verwenden werden wobei das Look und Feel via CSS geregelt wird. Standardmässig wird die *shared* Methode verwendet (`$useAppLayoutPath = true`). Die `$useAppLayoutPath` können Sie in der `Module.php` Datei als Klassen eigeschanft definieren.
```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{
    public $useAppLayoutPath = false; // nun werden die views im Modul Ordner gesucht
}
```

> Die `$useAppLayoutPath` eigenschaft sollte nur in Frontend Modulen verwendet werden.

Controllers
-----------
Wenn Sie einen Controller im CMS Content verwenden möchten um zusätzliche Meta infos zu setzen, abstrahieren Sie von `luya\base\PageController` anstelle von `luya\base\Controller`.

Context
-------
Die verwendung der `$context` variabel innerhalb eines views kann sehr effektiv sein bei *vielen controllern* und views. Wenn Sie eine *public* methode in einen Controller implenetieren, zbsp. `public function getBasketTotal()` kann diese Funktione innerhalb des views mit `$this->context->getBasketTotal()` aufgerufen werden. Wenn Sie nun eine `abstract` Controlle erstellen und diesen als `extends` benutzen so können Sie diese abstrahiert controller logik in allen views wieder verwenden.