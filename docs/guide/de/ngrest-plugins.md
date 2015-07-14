NgRest Plugins
==============
Hier findest du eine übersicht an Plungins welche du einem Feld zuweisen kannst. Hier ein Beispiel einer Anwendung des `text` Plugins auf das Feld `name`:

```php
$config->list->field('name', 'Vorname')->text();
```

Plugin Übersicht
-----------

| Name                                                  |  Description
| -------------------                                   | -------------
| text                                                  | Text Feld (max 255 zeichen)
| textarea                                              | Textarea (mehrzeilige eingabe text). 
| password                                              | Passwort Feld
| [select](start-ngrest-field-select.md)                | Select Dropdown Menu
| togglestatus                                          | Checkbox mit `0` und `1` werte.
| image                                                 | Erstellt ein Bild Uploader welche einen integer wert mit der Bild Id zurück gibt.
| imageArray                                            | Erstellt ein Bild und Text(Label) Mehrfach selektor.
| file                                                  | Erstellt ein Datei Uploader welche einen integer wert mit der Datei Id zurück gibt.
| [checkboxRelation](start-ngrest-field-checkboxRelation.md) | Eine Checkbox auswahl basierend auf einer *junction table*. 
| date                                          | Erstellt ein *Datum* Selektor Feld und gibt einen Unix Timestamp zurück.
| datetime                                          | Erstellt ein *Datum und Zeit* Selektor und gibt einen Unix Timestamp zurück.


Plugin implizieren
----------------

| Name                  | Description
|-----------------------| -------------------
| required              | Macht das Feld *zwingend* beim speichern.