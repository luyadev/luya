<?php

return [
    'model_site_id' => 'ID',
    'model_site_token' => 'Remote Token',
    'model_site_url' => 'Adresse',
    'model_site_auth_is_enabled' => 'Authentifizierung',
    'model_site_auth_user' => 'Auth User',
    'model_site_auth_pass' => 'Auth Password',
    'model_site_off' => 'Aus',
    'model_site_on' => 'An',
    'status_index_heading' => 'Remote Seiten Übersicht',
    'status_index_intro' => 'Aktuelle LUYA Version ist <a href="https://packagist.org/packages/luyadev/luya-core" target="_blank"><strong>{version}</strong></a>, veröffentlicht am {date}.',
    'status_index_caching_info' => 'Die Remote Daten werden für 15 Minuten im cache gespeicher. Mit dem Cache reload Knopf kannst du die Daten leeren.',
    'status_index_time_info' => '* Zeit: Gibt die total verstrichene Zeit des requests innerhalb des Systems zurück und nicht die dauer um den Request auf den Remote server zu machen.',
    'status_index_error_text' => 'Wenn die Abfrage Fehlerhaft war, könnten folgenden Ursachen das Problem ausgelöst haben:',
    'status_index_error_1' => 'Die Webseite ist über eine http auth autehntifizierung gesichert, du kannst diese login daten der Seite hinterlegen.',
    'status_index_error_2' => 'Die Webseite existiert nicht mehr unter dieser URL oder das falsche Protokoll wurde gewählt (http/https).',
    'status_index_error_3' => 'Der eingetragene remote token ist nicht korrekt und entspricht nicht dem aus der config der remote Seite.',
    'status_index_table_error' => 'Fehler beim Empfangen der Daten der Seite.',
    'status_index_column_time' => 'Zeit',
    'status_index_column_transferexception' => 'Fehler Übertragen',
    'status_index_column_onlineadmin' => 'Admins Online',
];
