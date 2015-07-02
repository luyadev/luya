Übersetzungen
=============
Um übersetzungen innerhalbt der *Controller* oder *Views* zu erstellen benutzen wir die Yii `translations` Komponent. Die müssen wir aber zuerst in der [Konfiguration](install-structures.md) einbetten und zwar im `components` Abschnitt. Diese könnte in etwa so ausshen:
```php
'components' => [
    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
            ],
        ],
    ]
]
```
> Denke Sie daran das Sie alle Komponenten in der `prep.php` und `prod.php` gleichermassen eintragen.

Nun werden alle *Messages-Source* Dateien die mit dem prefix `app` beginnen in die Übersetzung geladen. Um eine solche *Message-Source* Datei zu erstellen wechseln Sie in ihr Projekt-Verzeichnis und erstellen Sie den Ordner `messages`. Der Inhalt des Messages könnten nun wie folgt aussehen gemäss des *app* prefix beispiels:
```
.
└── messages
    ├── de
	│	├── app.php
	│	└── app-otherparts.php
    └── en
 		├── app.php
 		└── app-otherparts.php
```

Message-Source
---------------
Der Inhalt einer solchen *Message-Source* Datei gibt immer ein *array* zurück. Hier ein Beispiel für `messages/de/app.php`:
```
return [
    'title_top' => 'Hallo ich bin die Übersetzung Oben',
    'title_footer' => 'Hallo ich bin ein Footer Title',
    'body' => 'Ich bin die Body Variabel!',
];
```
Um nun auf diese Übersetzunge zuzugreifen benutzer wir
```php
echo Yii::t('app', 'title_top'); // Gibt "Hallo ich bin die Übersetzung Oben" zurück
```

Um eine Nachricht mit einem Paramter (also ein Dynamischer Wert welcher bei der ÜBersetzung nicht bekannt ist) zu erstellen, függen wir in der *Message-Source* Datei einen Platzhalter `{0}` ein. Wobei die Nummerierung der Anzahl Platzhalter entspricht.
```php
return [
	'datum' => 'Heute ist der <b>{0}</b> in Unixzeit.'
];
```
und bei der Ausgabe ersetzen wir `{0}` durch einen Wert:
```
echo Yii::t('app', 'datum', time()); // Gibt "Heute ist der <b>435829046</b> in Unixzeit" zurück.
```

Links
-----
+ [Mehr zum Thema Messages in der Yii Dokumentation](http://www.yiiframework.com/doc-2.0/guide-tutorial-i18n.html#message-translation)