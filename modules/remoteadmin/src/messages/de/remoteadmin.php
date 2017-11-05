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
    'status_index_caching_info' => 'Die Remote Daten werden für 2 Minuten im cache gespeicher. Mit dem Cache reload Knopf kannst du die Daten leeren.',
    'status_index_time_info' => '* Time: Returns the total elapsed time since the start of the request on the Remote application. Its the speed of the application, not the time elapsed to make the remote request.',
    'status_index_error_text' => 'If the request to a remote page returns an error, the following issues could have caused your request:',
    'status_index_error_1' => 'The requested website is secured by a httpauth authorization, you can add the httpauth credentials in the page configuration section.',
    'status_index_error_2' => 'The requested website url is wrong or not valid anymire. Make sure the url is correctly added with its protocol.',
    'status_index_error_3' => 'The requested website remote token is not defined in the config of the website itself or your enter secure token is wrong.',
    'status_index_table_error' => 'Fehler beim Empfangen der Daten der Seite.',
    'status_index_column_time' => 'Zeit',
    'status_index_column_transferexception' => 'Fehler Übertragen',
    'status_index_column_onlineadmin' => 'Admins Online',
];
