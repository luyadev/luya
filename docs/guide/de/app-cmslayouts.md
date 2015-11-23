CMS Layout
==========
Sobald *LUYA* mit dem CMS-Modul benutzt wird (dies ist bei einer Standardinstallation der Fall).

Alle CMS-Layouts werden im Projekt Views Verzeichnis `views` im Ordner `cmslayouts` abgelegt. Wenn wir nun ein neues Layout erstellen möchten mit 2 Spalten und dies `2columns` nennen würde der Pfad für die Twig Datei wie folgt aussehen `views/cmslayouts/2columns.twig`.

> Alle Layouts sind [Twig](http://twig.sensiolabs.org/) Dateien mit der Endung *.twig*.

Du kannst nun in deiner neuen *2columns.twig* Datei ein Markup hinterlegen und definieren wo die Platzhalter aus dem CMS System mit Benutzer-Blöcken abgefüllt werden dürfen. Um einen Platzhalter innerhalb des Layouts zu markieren fügst du den Code `{{placeholders.left}}` ein, wobei *left* die Bezeichnung des Platzerhalters ist. In unserem Beispiel mit 2 Platzerhaltern könnten ein Layout zbsp. wie folgt aussehn:

```html
<div class="row">
    <div class="col-md-6">
        {{placeholders.left}}
    </div>
    <div class="col-md-6">
        {{placeholders.right}}
    </div>
</div>
```

Dies wird dem Benutzer nun 2 Platzerhalter zur verfügung stellen an dem er Blöcke platzieren kann.

Importiern und Benutzen
-----------------------
Um ein neus Layout einzufügen oder ein bestehendes Layout zu aktualisieren öffnest du das Terminal und wechseln in das Projekt Verzeichniss. Dort führst du den `import` Befehl aus.

```sh
./vendor/bin/luya import
```

Der Import Prozess wird zurück geben was gemacht wurde:

```
[layouts] => Array
(
    [main.twig] => existing cmslayout main.twig updated.
    [2columns.twig] => existing cmslayout 2columns.twig updated.
)
```

> Die Namen der Platzhalter (labels) können im Administrationbereich unter *CMS-EInstellunge->Layouts* angepasst werden.

> Twig Funktionen funktionieren auf in einem CMS Layout.