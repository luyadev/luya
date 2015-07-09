NgRest
======
In dieser Sektion gehen wir nur auf das *NgRest Model* ein, um den ganzen zusammenhang und deren verbindung zu verstehen oder ein Beispiel einzurichten schaune Sie sich bitte die Sektion [Admin Modul NgRest Crud](app-admin-module-ngrest.md) an. *NgRest* ist ein verbindung zwischen Model, RestApi und Angular. Die NgRest konfiguration kann direkt auf den Output deines Models einfluss nehmen und dir komplexe arbeiten via *Plugins* abnehmen.

> Eine NgRest Tabelle muss einen eindeutigen Primary Key Feld (am besten ID) haben.

Wo konfigurieren?
-----------------
Die *NgRest* Konfiguration wird in der Methode `ngRestConfig($config)` hinterlegt, welche sich im *Model* der anzusprechenden Tabelle liegt, so könne wir direkten einfluss auf die Outputs der Modelle nehmen und deren *events* benutzen. Hier ein beispiel einer *NgRest* Konfiguration innerhalb des Models.

```php
public function ngRestConfig($config)
{
    $config->list->field('name', 'Name')->text()->required();
    $config->list->field('short_code', 'Kurz-Code')->text()->required();
    
    $config->create->copyFrom('list', ['id']);
    
    $config->update->copyFrom('list', ['id']);
    
    return $config;
}
```

In diesem Beispiel werden auf dem *list pointer* (Auflistung der Daten) das feld `name` und `short_code` angezeigt. Für das *update* (bearbeiten) und *create* (hinzufügen) Formular werden alle Daten aus der Listen übersicht kopiert (`copyFrom`) aber ohne das ID Feld (welches automatisch hinzugefügt wird zur listen übersicht). Der `copyFrom` befehl ist dazu da, dass die konfiguration nicht immer erneut eingegeben werden müssen das sich das bearbeiten und hinzufügen Formular meist nicht unterscheiden.

> Beim kopieren via `copyFrom` aus dem *list* pointer zu anderen Pointer müssen Sie das **id** Feld jeweils nicht mit kopieren da die ID nicht verändert werden sollten beim bearbeiten und via AI beim hinzufügen gesetzt wird.

Die Pointers
------------
Es gibt 4 verschiedene Interaktionen zwischen Crud und Model (via Angular) und somit in der *NgRest* config eingestellt werden können.

| pointer   | Beschreibung
| ---       | ---
| list      | Auflistung, Tabelarische darstellung der Daten.
| create    | Hinzufügen Formular, welche Felder sollen beim erstellen angzeigt werden.
| update    | Bearbeiten Formular eines Datensatz, welce Felder sollen bei bearbeiten angzeigt werden.
| delete    | Dürften Einträge werden oder nicht (Standard mässig ausgeschalten und muss via `$config->delete = true` expliziet aktiviert werden.
| aw        | *ActiveWindows*, hier kannst du eine eigenen Knöpfe anhängen und aktionen ausführen (zbsp. Passwort ändern, Bestellungs übersicht, gallery upload, etc.)

Einträge Entfernen
------------------
Wenn Sie den `delete` pointer aktivieren

```php
$config->delete = true;
``` 

wird ein Löschen Knopf eingefügt welcher standard mässig auf die [Yii AR delete methode](http://www.yiiframework.com/doc-2.0/yii-db-activerecord.html#delete()-detail) zugreift und den Eintrag unwiederruflich löscht. Sie können diese methode jedoch zu jederzeit auch für Ihre bedürfnisse anpassen und *überschreiben.

Wenn Sie ein *Soft-Delete* einführen möchten welches zbsp. auf das Feld `is_deleted` hört, und somit auch alle Einträge beim anzeigen ausblenden muss (überschreiben der `find()` methode) können Sie die `delete` und `find` methode überschreiben oder das `admin\traits\SoftDeleteTrait` einfügen:

```php
use admin\traits\SoftDeleteTrait;
```

über die `public static function SoftDeleteValues()` können Sie die Werte änderne welche für `delete` und `find` via trait gesetzt werden. Wobei der Array-Key dem Feld enstpricht und der Array-Value dem Wert welcher beim `delete()` event haben soll. Beim `find()` befehl werden die `SoftDeleteValues` inverted und umgekehrt verwendet.