<?php

return [
    'model_site_id' => 'ID',
    'model_site_token' => 'Token remoto',
    'model_site_url' => 'URL',
    'model_site_auth_is_enabled' => 'Protección de autenticación',
    'model_site_auth_user' => 'Autenticación de usuario',
    'model_site_auth_pass' => 'Autenticación  dec contraseña',
    'model_site_off' => 'Apagado',
    'model_site_on' => 'Encendido',
    'status_index_heading' => 'Descripción general de sitios remotos',
    'status_index_intro' => 'La versión actual de LUYA es <a href="https://packagist.org/packages/luyadev/luya-core" target="_blank"><strong>{version}</strong></a>, publicada en {date}.',
    'status_index_caching_info' => 'Los datos remotos se almacenarán en caché durante <strong>15 minutos</strong>. Puede usar el botón de recarga de caché para vaciar todo el caché de la página.',
    'status_index_time_info' => '* Hora: Devuelve el tiempo total transcurrido desde el inicio de la solicitud en la aplicación remota. Es la velocidad de la aplicación, no el tiempo transcurrido para realizar la solicitud remota.',
    'status_index_error_text' => 'Si la solicitud a una página remota devuelve un error, los siguientes problemas podrían haber causado su solicitud:',
    'status_index_error_1' => 'El sitio web solicitado está protegido por una autorización de httpauth, puede agregar las credenciales de httpauth en la sección de configuración de la página',
    'status_index_error_2' => 'El URL del sitio web solicitado es incorrecto o no válido. Asegúrese de que la URL se haya agregado correctamente con su protocolo. ',
    'status_index_error_3' => 'El token remoto del sitio web solicitado no está definido en la configuración del sitio web en sí o su token de seguridad de entrada es incorrecto',
    'status_index_table_error' => 'No se pueden recuperar datos de la página remota.',
    'status_index_column_time' => 'Tiempo',
    'status_index_column_transferexception' => 'Transferir excepciones',
    'status_index_column_onlineadmin' => 'Administradores en línea',
];
