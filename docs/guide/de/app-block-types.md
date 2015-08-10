Block Konfiguration und Typen
=============================
Hier versuchen wir die `config()` Methode mit deren Typen und Variable zu erklären. Die Konfiguration (auch config genannt) zeigt die Variabeln für den Benutzer input auf. Was für Daten kann der Administration-Benutzer eingeben, welche davon sind wichtig (vars) und welche eher für Entwickler (cfgs).

Typen
-----
Die config methode gibt in jedemfalle ein Array zurück wobei die erstes Ebene die jeweilige Konfigurations Typen definiert:

```php
return [
    'vars' => [],
    'cfgs' => [],
    'placeholders' => [],
];
```

> Sie müssen nur die von ihnen gewünschten Type zurück geben. Wenn Sie also keine Platzhalter (placeholders) oder Konfiguration (cfgs) haben reicht ein return der vars `return ['vars' => []];`.

| Name | Funktion
| ---- | --------
| vars | Enthält alle Variabeln die wir dem Benutzer auf den ersten Blick zeigen möchten. Keine Technischen Inputs.
| cfgs | Dies sind Technische Elemente wie zbsp. eine Css-Klasse für ein Element.
| placeholders | Erzeugt dir neue Platzhalter um eine weitere verschachtelung zu ermöglichen. Wenn du ein Box hast wo wir danach weiter Element Blöcke hineinziehen können zbsp.

Typen-Feld
-------------
Wenn du nun einen Eintrag zu einem Typen einfügen möchtest musst du einen *Typen Feld* erstellen, also ein Element innerhalb des Typen-Arrays. Ein Typen eintrag sollte immer aus den keys `var`, `label` und `type` verfügen, zum Beispiel:

```php
[
    'var' => 'userInputText',
    'label' => 'Beschreibung von userInputText',
    'type' => 'zaa-text',
] 
```

Dies würde dem Benutzer eine Eingabevariabel erstellen mit einem Text Input und dem Label darüber *Beschreibung von userInputText*. Typen-Feld und Typen-Element zusammengsetzt würde also wie folgt aussehen:

```php
return [
    'vars' => [
        ['var' => 'userInputText', 'label' => 'Beschreibung von userInputText', 'type' => 'zaa-text']
    ]
];
```

Typen-Feld-Typen
------------------
Natürlich benötigen wir mehr als nur Textfelder für die Typen-Einträge. Hier eine Übersicht aller möglichen Type und deren Rückgabe Wert und beschreibung.

| Name                      | Rückgabewert  | Beschreibung 
| -----                     | ------------  | ----------------------------------
| zaa-text                  | string        | Erstellt ein Text `input type=text`. 
| zaa-password              | string        | Erstellt ein Passwort Feld `input type=password`. 
| zaa-textarea              | string        | Erstellt ein mehrzeiliges Textfeld `textarea`. 
| zaa-number                | string        | Erstellt ein Feld wobei nur Zahl als valider input gelten.
| zaa-wysiwyg               | string        | Erstellt einen WYSIWYG Editor mit verschiedene Formatierungs möglichkeiten. 
| zaa-select                | array         | Erstellt ein Select-Dropdown mit Optionen. options: ein array wobei bei jedem Eintrag *value* und *label* enthalten muss. Der vorausgewählte Werte wird über *initvalue* angegeben. Dieser wird auch bei einer Abfrage des Feldes zurückgegeben. 
| zaa-datetime              | int           | Erstellt eine Datums und Zeiteingabe. Die Rückgabe ist ein *Unix-Timestamp*.
| zaa-date                  | int           | Erstellt eine Datums eingabe. Die Rückt ist ein *Unix-Timestamp* 
| zaa-checkbox				| int			| Erstellt eine Checkbox und gibt 0 oder 1 zurück. Options: `zaa-checkox options="{'true-value':1, 'false-value':0}"`.
| zaa-checkbox-array        | array         | Erstellt ein Checkbox anahnd das options parameter. 
| zaa-file-upload           | int           | Erstellt ein Fileupload Feld für eine Datei. Die Rückgabe ist eine *file_id* aus dem Storage-System.
| zaa-file-array-upload     | array         | Erstellt ein Fileupload für ein oder mehr Dateien. Die Rückgabe ist per Array *file_id* und *caption*.
| zaa-image-upload          | int           | Erstellt einen Bildupload Feld für eine Datei. Die Rückgabe ist eine *image_id* aus dem Storage-System. Options: `options="{no_filter:true}"` blendet die Filter auswahl aus.
| zaa-image-array-upload    | array         | Erstellt ein Bildupload für ein oder mehr Bilder. Die Rückgabe ist per Array *image_id* und *caption*. 
| zaa-list-array            | array         | Erstellt einen Textinput für mehrer Eingaben. (zbsp. Listen).
| zaa-table					| array			| Erstellt eine Tabelle anhand eines Json inputs. Der rückgabe Wert ist ein Array wobei der Key dem Spalten-Namen entspricht.
