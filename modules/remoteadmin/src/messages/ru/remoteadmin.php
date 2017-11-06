<?php

return [
    'model_site_id' => 'ID',
    'model_site_token' => 'Удаленный токен',
    'model_site_url' => 'URL',
    'model_site_auth_is_enabled' => 'Аутентификация',
    'model_site_auth_user' => 'Пользователь',
    'model_site_auth_pass' => 'Пароль',
    'model_site_off' => 'Выкл.',
    'model_site_on' => 'Вкл.',
    'status_index_heading' => 'Обзор удаленных сайтов',
    'status_index_intro' => 'Текущая версия LUYA <a href="https://packagist.org/packages/luyadev/luya-core" target="_blank"><strong>{version}</strong></a>, от {date}.',
    'status_index_caching_info' => 'Удаленные данные будут закешированны в течении <strong>15 минут</strong>. Вы можете использовать кнопку очистки кеша, чтобы очистить кеш всей страницы.',
    'status_index_time_info' => '* Время: Возвращает общее истекшее время с момента запуска запроса в удаленном приложении. Это скорость приложения, а не время удаленного запроса.',
    'status_index_error_text' => 'Если запрос на удаленную страницу возвращает ошибку, следующие проблемы могут быть причиной:',
    'status_index_error_1' => 'Запрошенный веб-сайт защищен авторизацией httpauth, вы можете добавить учетные данные httpauth в разделе конфигурации страницы.',
    'status_index_error_2' => 'Запрошенный URL-адрес веб-сайта неверен или недействителен. Убедитесь, что URL-адрес верный.',
    'status_index_error_3' => 'Запрашиваемый удаленный токен веб-сайта не определен в конфигурации самого веб-сайта или введен неверно.',
    'status_index_table_error' => 'Не удается получить данные с удаленной страницы.',
    'status_index_column_time' => 'Время',
    'status_index_column_transferexception' => 'Ошибки переноса',
    'status_index_column_onlineadmin' => 'Админы онлайн',
];
