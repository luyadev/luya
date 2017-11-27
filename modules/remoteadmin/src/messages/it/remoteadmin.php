<?php

return [
    'model_site_id' => 'ID',
    'model_site_token' => 'Token remoto',
    'model_site_url' => 'URL',
    'model_site_auth_is_enabled' => 'Login abilitato',
    'model_site_auth_user' => 'Login User',
    'model_site_auth_pass' => 'Login Password',
    'model_site_off' => 'Off',
    'model_site_on' => 'On',
    'status_index_heading' => 'Overview sui siti remoti',
    'status_index_intro' => 'Versione attuale LUYA: <a href="https://packagist.org/packages/luyadev/luya-core" target="_blank"><strong>{version}</strong></a>, rilasciata il {date}.',
    'status_index_caching_info' => 'I dati remoti saranno in cache per <strong>15 minutes</strong>. Puoi usare il bottone cache-reload per refreshare l\'intera cache della pagina.',
    'status_index_time_info' => '* Time: ritorna il tempo totale trascorso dall\'inzio della richiesta sull\'applicazione remota. Indica la velocità dell\'applicazione, non il tempo intercorso per fare la richiesta remota.',
    'status_index_error_text' => 'Se la richiesta alla pagina remota ritorna un errore, la richiesta potrebbe aver avuto i seguenti problemi:',
    'status_index_error_1' => 'Il sito web richiesto è protetto da un\'autorizzazione httpauth, puoi aggiungere le credenziali httpauth nelle configurazioni della pagina.',
    'status_index_error_2' => 'L\'url del sito web richiesto è sbagliato o non è più valido. Assicurati che l\'url è corretto e che ci sia il protocollo (https/http).',
    'status_index_error_3' => 'Il token relativo al sito web richiesto non è definito nelle configurazioni del sito, oppure potresti aver inserito il token in modo errato.',
    'status_index_table_error' => 'Impossibile recuperare i dati dalla pagina remota.',
    'status_index_column_time' => 'Time',
    'status_index_column_transferexception' => 'Eccezioni di trasferimento',
    'status_index_column_onlineadmin' => 'Amministratori online',
];
