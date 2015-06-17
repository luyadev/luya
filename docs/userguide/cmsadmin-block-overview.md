CMS BLOCK ÜBERSICHT
===================

Überblick über alle verfügbaren Basis CMS Blöcke.


| Block Name          | Typ      |  Beschreibung
| ------------------- | ---------| -------------
| Überschrift    	  | Einfach  | Titel
| Text		          | Einfach  | Text Block
| Texteditor		  | Einfach  | Text mit Formatierung über einen Editor
| Zitat               | Einfach  | Ein besonders hervorgehobenes Zitat
| Bild		          | Einfach  | Einfaches Bild
| Karte	              | Einfach  | Google Map Kartenausschnitt mit Anzeige einer definierten Adresse
| Auflistung          | Einfach  | Liste
| Aufzählung          | Einfach  | Durchnummerierte Liste
| Code                | Einfach  | HTML Code Block
| Link                | Einfach  | HTML Link zu einer URL
|                     |          |
| Trenner             | Struktur | Trennlinie
| Abstandhalter       | Struktur | Variable Leerfläche


Block-Text
---------
Variabeln:
var.content = Inhalt selber
cfg.isMarkDown = Wird var.content als markdown gepartste ja/nein

Block-Link
-----
| var           | type           | label
----------------------------------------
| href          | zaa-text      | Ziel-Adresse

var.href = Den Link
var.target = blank oder nicht


