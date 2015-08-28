Html Element Komponenten
========================
Die Idee hinter den *Html Element Komponenten* basiert auf den *Angular Direktiven*. Ein vielzahl von Strukturierten Element welche wieder verwendet werden können an verschiedenen Orten. Ein Beispiel für eine Element Komponenten *Teaser-Box*, der Html Code

```html
<div class="teaser-box">
	<h1>Titel</h1>
	<p>Beschreibung</p>
	<a class="btn btn-primary" href="https://luya.io">Mehr erfahren</a>
</div>
```

wird in mehreren Templates immer wieder verwendet. Sobald sich diese Element Komponenten *Teaser-Box* verändert und zbsp. ein zusätzliches Wrapper Div anfügt, muss dies jeweils an allen verwendeten stellen angepasst werden.

```html
<div class="teaser-box">
	<div class="teaser-box-wrapper">
		<h1>Titel</h1>
		<p>Beschreibung</p>
		<a class="btn btn-primary" href="https://luya.io">Mehr erfahren</a>
	</div>
</div>
```

Elemente hinzufügen
--------------------
Um diese Problem zu lösen verwenden wir die *Element Komponente*. Im Root Ordner deines Projekts (`@app`) kannst du eine `elements.php` Datei erstellen welche ein Array mit Element zurück gibt. Ein Element besteht aus einem *Namen* und einer *Closure* wobei die Closure verschiedene Funktionen erledigen kann. Um einen saubere und sinvolle Struktur aufzubauen verwenden so viel möglich Teilbare Elemente die später verändert werden können.

```php
<?php
return [
	'button' => function($href, $name) {
		return '<a class="btn btn-primary" href="'.$href.'">'.$name.'</a>';
	},
	'teaserbox' => function($title, $description, $buttonHref, $buttonName) {
		return '<div class="teaser-box"><h1>'.$title.'</h1><p>'.$description.'</p>'.$this->button($buttonHref, $buttonName).'</div>
	},
];
```

Das oben abgebildete Beispiel von `elements.php` enthält 2 Elemente:

1. Button: Ein Template für einen Knopf
2. Teaserbox: Eine Teaserbox welche wiederum das Button Element einfügt.

> Elemente können natürlich jederzeit auch dynamisch registriert werden über `Yii::$app->element->addElement('elementName', function() { });`.

Elemente benutzen
=================
Um die oben hinzugefügten Element *button* und *teaserbox* zu verwenden kannst du in jeder beliebigen Code stelle (controller, views, layouts) die Komponenten `Yii::$app->element` wie folgt benutzen:

```php
echo Yii::$app->element->button('https://luya.io', 'Mehr erfahren');
```

> In einer View-Datei (layouts, views) muss das Element mit `echo` ausgegeben werden.

In einem Twig-Template kann die Funktion `element` wie folgt verwendet werden:

```
{{ element('button', 'https://luya.io', 'Mehr erfahren') }}
```

Wobei der erste Parameter dem aufzurufenden Element entspricht und die nachfolgenden Parameter der Element-Funktions Parameter entsprechen.

Rendern
=======
Bei komplexeren Elementen ist das Verknüpfen (concatenation) von String und Variablen keine bequeme sache. Aus diesem Grund kann innerhalb der Closure-Funktion auch die `render()` Methoden aufgerufen werden um Twig Files zu rendern mit dere dazugehörigen Parametern.

```php
//...
'button' => function($href, $name) {
	return $this->render('button', ['href' => $href, 'name' => $name ]);
},
//..
```

Dies wird im Verzeichnes `@app/views/elements` nach der Twig-Datei `button.twig` suchen und dieser Rendern. So könnten `@app/views/elements/button.twig` zum beispiel aussehen:

```
<a href="{{ href }}" class="btn btn-primary">{{ name }}</a>
```

### Rekursives Rendering

Natürlich ist auch erlaubt in Twig-Datei andere element anzusprechen. Somit würde im Beispiel der Teaserbox das Template wie folgt aussehen:

```
<div class="teaser-box">
	<h1>{{ title }}</h1>
	<p>{{ description }}</p>
	{{ element('button', buttonHref, buttonName) }}
</div>
```

Das obenzeigte Template setzt natürlich voraus das alle Variabeln `title`, `description`, `buttonHref` und `buttonName` in die render methode assigend wurden.

Styleguide
==========

@TBD

