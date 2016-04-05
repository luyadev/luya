LUYA aktualisieren
==================

Diese Sektion erklärt wie man LUYA bei einem neuen Versions Release upgrade kann. Die aktuelle Version von LUYA ist `1.0.0-beta5`. Eine sicherung der Datenbank und des `storage` Ordners wird empfohlen.

> Dieser Guide erklärt das aktualle Upgrade von `1.0.0-beta4` auf `1.0.0-beta5`.

### Composer

Öffne deine `composer.json` Datei, diese findest du im Root-Verzeichniss deines Projekts. Passe die Packete im `require` Abschnitt an:

```
"require": {
    "luyadev/luya" : "1.0.0-beta5",
    "luyadev/luya-module-cms" : "1.0.0-beta5",
    "luyadev/luya-module-cmsadmin" : "1.0.0-beta5",
    "luyadev/luya-module-admin" : "1.0.0-beta5"
}
```

> Wenn du noch mehr Module integriert hast, solltest du diese auch auf die neuste Version upgraden.

Nachdem du die neue Version in der `composer.json` Datei hinterlegt und gespeichert hast führe den `update` befehl wie folgt aus:

```sh
composer update
```

Dies wird dir nun ein neues composer.lock file generieren und kann einige Minuten dauern. Die neuen LUYA Daten wurden somit erfolgreich in das vendor Verzeichniss gespeichert. Das aktualisiere `composer.lock` file kannst du nun in dein VCS hinzufügen, somit können anderen Personen die an diesem Projekt arbeiten lediglich den `composer install` befehl ausführen.

> Wenn du einen Fehler beim Updaten erhältst, stelle sicher dass du `"minimum-stability" : "beta"` eingestellt hast.

### Konsole

Als letzten Schritt zum upgraden einer LUYA Version gehst du nun in Konsole. Als erstes führen wir die neuen Migrations-Scripte aus.

```sh
./vendor/bin/luya migrate
```

Die Datenbank ist nun aktualisiert und up-to-date. Nun führen wir den `import` befehl aus, welcher verschiedene Teile des Systems aktualisert.

```sh
./vendor/bin/luya import
```

Wenn es bestimmte Funktionen oder Klasse nicht mehr funktionieren oder sich verändert haben steht dies im *CHANGELOG.MD* mit dem Prefix *[BC BREAK]*.

