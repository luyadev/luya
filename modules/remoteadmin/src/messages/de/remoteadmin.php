<?php

return [
    'model_site_id' => 'ID',
    'model_site_token' => 'Remote-Token',
    'model_site_url' => 'Adresse',
    'model_site_auth_is_enabled' => 'Authentifizierung',
    'model_site_auth_user' => 'Auth Benutzer',
    'model_site_auth_pass' => 'Auth Passwort',
    'model_site_off' => 'Aus',
    'model_site_on' => 'An',
    'status_index_heading' => 'Remote Seiten Übersicht',
    'status_index_intro' => 'Aktuelle LUYA Version ist <a href="https://packagist.org/packages/luyadev/luya-core" target="_blank"><strong>{version}</strong></a>, veröffentlicht am {date}.',
    'status_index_caching_info' => 'Die Remote-Daten werden für 15 Minuten im Cache gespeichert. Mit dem Cache-Reload-Button kannst du die Daten leeren.',
    'status_index_time_info' => '* Zeit: Gibt die Gesamtzeit des Requests innerhalb des Systems zurück und nicht nur die Dauer um den Request bis zum Remote Server zu übermitteln.',
    'status_index_error_text' => 'Wenn die Abfrage fehlerhaft war, könnten folgenden Ursachen das Problem ausgelöst haben:',
    'status_index_error_1' => 'Die Webseite ist über eine HTTP-Authentifizierung gesichert, bitte gib die entsprechenden Login-Daten mit an.',
    'status_index_error_2' => 'Die Webseite existiert nicht mehr unter dieser URL oder es wurde ein falsches Protokoll gewählt (http/https).',
    'status_index_error_3' => 'Der eingetragene Remote-Token ist nicht korrekt und entspricht nicht dem aus der Konfiguration der Remote-Seite.',
    'status_index_table_error' => 'Fehler beim Empfangen der Seitendaten.',
    'status_index_column_time' => 'Zeit',
    'status_index_column_transferexception' => 'Fehler übertragen',
    'status_index_column_onlineadmin' => 'Admins Online',
];
