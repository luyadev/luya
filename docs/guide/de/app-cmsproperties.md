Cms Seiten Eigenschaften
========================

Was ist eine Seiten Eigenschaft?
--------------------------------

Ein Beispiel für eine *Seiten Eigenschaft* könnten zbsp. die Farbe sein. Jede von deinen Seiten soll über eine bestimmte Farbe verfügen. Diese Farbe verändert danach im Frontend oder im Block das aussehen der Seite. Anstelle diese Konfigurations-Option in jedem Block mühsam zu implenetieren erstellen wir eine sogenan **property** auf diese du danach im Block oder auf der Seite zugreifen kannst.

Weitere Anwendungsbereiche:

+ Hintergrund Bilder.
+ Farbe, Css-Klassen für Inhalte.
+ Spezifisch Meta Informationen wie Facebook.
+ Daten Verknüpfung für Side-Boxen aus anderen Modulen.

Hinzufügen einer Eigenschaft
----------------------------

Das Luya system versucht alle Informationen, Plugins und Addons als Dateien zu hinterlegen und danach ins System zu [importieren](luya-console.md), das fordert eine gewissen Anspruch an den Integrator, Daten können dafür zuverlässig via VCS-Systeme kontrolliert werden. Dies gilt auch für *Eigenschaften* (*properties*).

Um eine neue Eigenschaft anzulegen gehst du in deine *Projekt* (*app*) oder *Modul* (*module*) Ordner und erstellst einen Ordner **properties**. Alle *properties* Klassen müssen den suffx *Property* besitzen. Hier eine Beispiel Klasse namens `TestProperty` im Projekt (app) Namespace:

```php
<?php

namespace app\properties;

class TestProperty extends \admin\base\Property
{
    public function varName()
    {
        return 'foobar';
    }    
    
    public function label()
    {
        return 'Foo Bar Label';
    }
    
    public function type()
    {
        return 'zaa-select';
    }
    
    public function defaultValue()
    {
        return 'ul';
    }
    
    public function options()
    {
        return [
            ['value' => 'ul', 'label' => 'Stichpunktliste'],
            ['value' => 'ol', 'label' => 'Nummerierte Liste'],
        ];
    }
}
```

Um diese erstellte `TestProperty` Klasse in das System einzuspielen, muss (wie bereits oben erklärt) dere [Import Konsolenbefehl](luya-console.md) ausgeführt werden. Jede änderung der Klasse (zbsp. Text Korrektur im Label) muss durch den Import-Prozess aktualisert werden.

### Die Klassen-Methoden

|methode	|Optional	|Erklärung
|---		|---		|---
|varName	|nein		|Der Name der Variabel mit welcher du deine Werte assozierst. Wenn du auf die Daten zugreifen willst wirst du diesen Namen wieder benötigen.
|label		|nein		|Die erklärung deiner Variable, diese wird dem End-Benutzer des Administrations-Systems angezeigt.
|type		|nein		|Definiert den Input-Type der Variable. Alle [Block-Typen](app-block-types.md) stehen dir zur Verfügung.
|options	|ja			|Sepzifische Typen wie *select* oder *checkbox-array* benötigen zusätlich Optionen, diese werden über diese Methode definiert.
|defaultValue|ja		|Gewissen Typen haben einen *initvalue* diese Methode entspricht diesem Wert. Standard ist `false`.

Auf Eigenschaften Zugreifen
---------------------------

Aktuell gibt es nur einen Anwendungs Zweck für das Zugreifen der *Eigenschaft* (*property*), innerhalb eines [Blocks](app-blocks.md). Um innerhalb eines Block auf die oben Erstellte Variable `foobar` innerhalb des Property Klasse `TestProperty` zuzugreifen kannst du innerhalb der Block methoden auf das Seiten-Object (*pageObject*) zugreifen mit der methode `getEnvOption('pageObject')`. Eigenschaften werden einem *Nav* eintrag hinterlegt, das Seiten-Object ist jedoch der *NavItem* Eintrag. Aus diesem Grunde muss innerhalb des *NavItem* Objecs (welches pageObject entspricht) auf die Methode `getNav()` zugefriffen werden welches über die nötigen Methoden zum ausgeben und anzeigen der Eigenschaften verfügt. Hier ein Beispiel aufruf der `foobar` Variable aus unserer `TestProperty` Klasse:

```php
$this->getEnvOption('pageObject')->getNav()->getProperty('foobar');
```

> Wenn die Eigenschaft nicht für diese Seite hinterlegt wurde (also keine Wert für für die Eigenschaft hinterlegt) gibt die Funktion immer `false` zurück.

um alle Eigenschaften für diese Seite (in der der Block abglegt wurde) anzuziegen verwenden Sie die `getProperties()` Methode:

```php
$this->getEnvOption('pageObject')->getNav(9->getProperties();
```


