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
Alle Controller müssen von `luya\base\Controller` abstrahieren.

> `luya\base\PageController` ist nicht mehr valid seit Version 1.0.0-alpha11.

Standard Route
--------------
Per Yii defintioni wird als standard controller und index der `DefaultController` und die `indexAction` ausgeführt. Um diese zu ändern kanns du im Module die Property `$defaultRoute` auf deine standrd *<controller>/<action>* route anpassen, ein paar Beispiele:

```php
public $defaultRoute = 'cat'; // neue standard route: cat/index

public $defaultRoute = 'detail/index'; // neue standard route: detail/index

public $defaultROute = 'detail'; // neue standard route: detail/index
```

Context
-------
Die verwendung der `$context` variabel innerhalb eines views kann sehr effektiv sein bei *vielen controllern* und views. Wenn Sie eine *public* methode in einen Controller implenetieren, zbsp. `public function getBasketTotal()` kann diese Funktione innerhalb des views mit `$this->context->getBasketTotal()` aufgerufen werden. Wenn Sie nun eine `abstract` Controlle erstellen und diesen als `extends` benutzen so können Sie diese abstrahiert controller logik in allen views wieder verwenden.

Titel und Meta-Tags
-------------------
In einer Action kann die Titel Tag (title tag) Eigenschaft über den view definiert werden:

```php
public function actionIndex()
{
    // etwas passiert hier
    
    $this->view->title = 'Ich bin der Seiten Titel';
    
    return $this->render('index');
}
```

Der Titel kann aber auch direkt im obenangange render file `index` gesetzt werden, also im PHP-Template:

```php
<? $this->title = 'Ich bin der Seiten Titel im Template'; ?>
<h1>Hallo Welt</h1>
<p>... Restliche ausgabe des Templates</p>
```

+ [Titel-Tag Yii](http://www.yiiframework.com/doc-2.0/guide-structure-views.html#setting-page-titles)

Das selbe gilt für Meta informationen, im controller:

```php
public function actionIndex()
{
    $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'luya, yii, php']);
    
    return $this->render('index');
}
```

oder direkt im view file

```php
<? $this->registerMetaTag(['name' => 'keywords', 'content' => 'luya, yii, php']); ?>
<h1>Hallo Welt</h1>
<p>... Restliche ausgabe des Templates</p>
```

Um die meta description des CMS zu überschreiben benutze **registerMetaTags** mit dem keyword **metaDescription** wie folgt:

```
$this->view->registerMetaTag(['name' => 'description', 'content' => $model->description], 'metaDescription');
```

+ [Meta-Tags Yii Dokumentation](http://www.yiiframework.com/doc-2.0/guide-structure-views.html#registering-meta-tags)