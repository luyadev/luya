<?php

return [
    'model_site_id' => 'ID',
    'model_site_token' => 'Remote Token',
    'model_site_url' => 'URL',
    'model_site_auth_is_enabled' => 'Auth protection',
    'model_site_auth_user' => 'Auth User',
    'model_site_auth_pass' => 'Auth Password',
    'model_site_off' => 'Off',
    'model_site_on' => 'On',
    'status_index_heading' => 'Remote Sites Overview',
    'status_index_intro' => 'Current LUYA Version is <a href="https://packagist.org/packages/luyadev/luya-core" target="_blank"><strong>{version}</strong></a>, released at {date}.',
    'status_index_caching_info' => 'The Remote Data will be cached for <strong>15 minutes</strong>. You can us the cache-reload button to flush the whole page cache.',
    'status_index_time_info' => '* Time: Returns the total elapsed time since the start of the request on the Remote application. Its the speed of the application, not the time elapsed to make the remote request.',
    'status_index_error_text' => 'If the request to a remote page returns an error, the following issues could have caused your request:',
    'status_index_error_1' => 'The requested website is secured by a httpauth authorization, you can add the httpauth credentials in the page configuration section.',
    'status_index_error_2' => 'The requested website url is wrong or not valid anymore. Make sure the url is correctly added with its protocol (https/http).',
    'status_index_error_3' => 'The requested website remote token is not defined in the config of the website itself or your enter secure token is wrong.',
    'status_index_table_error' => 'Unable to retrieve data from the Remote Page.',
    'status_index_column_time' => 'Time',
    'status_index_column_transferexception' => 'Transfer Exceptions',
    'status_index_column_onlineadmin' => 'Admins Online',
];
