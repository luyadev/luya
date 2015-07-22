News-Admin Modul
==================
Das News Admin Modul bietet die Möglichkeit, New-Einträge zu erfassen, zu kategorisieren und Tags zu vergeben. Es gibt 3 Kategorien in der Adminoberfläche:

* News Eintrag
* Kategorien
* Tags

Im **News Eintrag** werden alle News angezeigt, es können neue angelegt und bestehende gelöscht werden. Wenn man einen News Eintrag anlegt, wählt man die Kategorie aus, in dem er geführt werden soll und man gibt neben Titel und der Beschreibung noch das Erstelldatum und eventuell eine zeitliche Einschränkung an, aber der die News erst angezeigt werden soll. Ausserdem kann man ein Bild auswählen, was dann z.B. als Thumbnail angezeigt werden kann. Falls gewünscht kann man noch Bilder zu der News hochladen und Dateien, wie z.B. eine PDF anhängen. Zum Schluss können noch die bereits definierten Tags zugeordnet werden.

Unter den **Kategorien** werden die News Kategorien verwaltet. Diese können hier also neu angelegt, editiert und gelöscht werden. Zu beachten ist, dass Kategorien nur gelöscht werden können, wenn es keine News mehr gibt, die dieser zugeordnet ist.

In **Tags** findet man die Verwaltung der News-Tags. Es können hier allerdings auch Tags gelöscht werden, auch wenn sie noch in Benutzung sind.

Methoden zur Benutzung im Frontend (View)
-----------------------------------------

Die Funktion `getDetailUrl()` liefert die URL Route zu der Detailseite des jewiligen Modells zurück. Ruft man die Funktion aus einem Widget oder einem Block auf, gibt man noch den jeweiligen Navigationskontext mit `$contextNavItemId` an.

Die statische Methode `getAvailableNews()` liefert alle New Artikel zurück, die ab dem momentanen Zeitpunkt (Serverzeit) sichtbar sind.

Beispiele für die Anwendung findet man im [Frontend Pendant](module-news) des News-Admin Moduls.

