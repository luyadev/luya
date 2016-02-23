<?php

return [
    // global
    'language_name' => 'Русский',
    'button_save' => 'Сохранить',
    'button_abort' => 'Отмена',
    'button_send' => 'Отправить',

    // login
    'login_pre_title' => 'Авторизоваться в {title}',
    'login_mail' => 'Email',
    'login_password' => 'Пароль',
    'login_btn_login' => 'Вход',
    'login_securetoken' => 'Секретный код',
    'login_securetoken_info' => 'Введите код безопасности, который был отправлен на ваш адрес электронной почты.',

    // menu nodes
    'menu_node_system' => 'Система',
    'menu_node_filemanager' => 'Файловый менеджер',

    // menu groups
    'menu_group_access' => 'Доступ',
    'menu_group_system' => 'Система',
    'menu_group_images' => 'Изображения',

    // menu items
    'menu_access_item_user' => 'Пользователи',
    'menu_access_item_group' => 'Групы',
    'menu_system_item_language' => 'Языки',
    'menu_system_item_tags' => 'Теги',
    'menu_images_item_effects' => 'Эффекты',
    'menu_images_item_filters' => 'Фильтры',

    // admin/dashboard
    'dashboard_title' => 'Добро пожаловать.',
    'dashboard_text' => 'Вы можете переключаться между модулями главной навигации в верхней части экрана.<br />Меню слева, дает доступ к функциям выбранного модуля.',

    // layout
    'layout_select_file' => 'Выберите файл',
    'layout_deleted_file' => 'Вы не можете применить фильтр, потому что исходный файл был удален. Загрузить или выберите новый файл, чтобы применить фильтр.',
    'layout_no_filter' => 'Нет фильтра',
    'layout_debug_table_key' => 'Название',
    'layout_debug_table_value' => 'Значение',
    'layout_filemanager_save_dir' => 'Сохранить?',
    'layout_filemanager_remove_dir' => 'Удалить папку?',
    'layout_filemanager_remove_dir_not_empty' => 'Папка не пуста - все равно удалить?',
    'layout_filemanager_remove_selected_files' => 'Удалить отмеченные файлы',
    'layout_filemanager_move_selected_files' => 'Переместить',
    'layout_filemanager_upload_error' => 'Ошибка при загрузке файла',
    'layout_filemenager_col_name' => 'Название',
    'layout_filemanager_col_type' => 'Тип',
    'layout_filemanager_col_date' => 'Дата создания',
    'layout_filemanager_col_name' => 'Название файла',
    'layout_filemanager_detail_date' => 'Дата создания',
    'layout_filemanager_detail_filetype' => 'Тип файла',
    'layout_filemanager_detail_size' => 'Размер',
    'layout_filemanager_detail_id' => 'Внутренний ID',
    'layout_filemanager_detail_download' => 'Скачать',
    'layout_btn_reload' => 'перезагрузить',
    'layout_btn_version' => 'Версия',
    'layout_btn_useronline' => 'Пользователи в сети',
    'layout_btn_logout' => 'Выйти',
    'layout_btn_profile' => 'Профиль',
    'layout_debug_luya_version' => 'Версия Luya',
    'layout_debug_id' => 'ID',
    'layout_debug_sitetitle' => 'Название сайта',
    'layout_debug_remotetoken' => 'Удалить маркер',
    'layout_debug_assetmanager_forcecopy' => 'AssetManager forceCopy', // no translation
    'layout_debug_transfer_exceptions' => 'Transfer Exceptions', // no translation
    'layout_debug_yii_debug' => 'YII_DEBUG', // no translation
    'layout_debug_yii_env' => 'YII_ENV', // no translation
    'layout_debug_app_language' => 'Yii App Language', // no translation
    'layout_debug_luya_language' => 'Luya Language', // no translation
    'layout_debug_yii_timezone' => 'Yii Timezone', // no translation
    'layout_debug_php_timezone' => 'PHP Timezone', // no translation
    'layout_debug_php_ini_memory_limit' => 'PHP memory_limit', // no translation
    'layout_debug_php_ini_max_exec' => 'PHP max_execution_time', // no translation
    'layout_debug_php_ini_post_max_size' => 'PHP post_max_size', // no translation
    'layout_debug_php_ini_upload_max_file' => 'PHP upload_max_filesize', // no translation
    'layout_search_min_letters' => 'Пожалуйста, введите слово для поиска. <b>Минимум три буквы</b>.',
    'layout_search_no_results' => 'Записей не найдено.',
    'layout_filemanager_upload_files' => 'Добавить файл',
    'layout_filemanager_folder' => 'Папка',
    'layout_filemanager_add_folder' => 'Добавить папку',
    'layout_filemanager_root_dir' => 'Корневая папка',

    // aws/groupauth
    'aws_groupauth_select_all' => 'Выделить все',
    'aws_groupauth_deselect_all' => 'Снять все',
    'aws_groupauth_th_module' => 'Модули',
    'aws_groupauth_th_function' => 'Функция',
    'aws_groupauth_th_add' => 'Добавить',
    'aws_groupauth_th_edit' => 'Редактировать',
    'aws_groupauth_th_remove' => 'Удалить',

    // models/group
    'model_group_name' => 'Название',
    'model_group_description' => 'Описание',
    'model_group_user_buttons' => 'Пользователь',
    'model_group_btn_aws_groupauth' => 'Разрешения',

    //views/ngrest/crud
    'ngrest_crud_btn_list' => 'Записи',
    'ngrest_crud_btn_add' => 'Добавить',
    'ngrest_crud_btn_close' => 'Закрыть',
    'ngrest_crud_search_text' => 'Введите слово для поиска...',
    'ngrest_crud_rows_count' => 'Записи',
    'ngrest_crud_btn_create' => 'Создать',

    // apis
    'api_storage_image_upload_error' => 'Произошла ошибка при загрузке изображения \'{error}\'.',
    'api_storage_file_upload_success' => 'Файлы были успешно загружены.',
    'api_sotrage_file_upload_error' => 'Произошла следующая ошибка при загрузки файла \'{error}\'.',
    'api_sotrage_file_upload_empty_error' => 'Не найдено файлов для загрузки. Выбрали ли вы какие-то файлы?',

    // aws/changepassword
    'aws_changepassword_info' => 'Пожалуйста введите новый пароль. Пароль должен состоять минимум из 6 символов.',
    'aws_changepassword_succes' => 'Пароль успешно изменен.',
    'aws_changepassword_new_pass' => 'Новый пароль',
    'aws_changepassword_new_pass_retry' => 'Повторите пароль',

// added translation in 1.0.0-beta3:

    // models/LoginForm
    'model_loginform_email_label' => 'Email',
    'model_loginform_password_label' => 'Пароль',
    'model_loginform_wrong_user_or_password' => 'Неверный логин или пароль.',

    'ngrest_select_no_selection' => 'Ничего не выбрано',

    // js data
    'js_ngrest_error' => 'Произошла ошибка при загрузке.',
    'js_ngrest_rm_page' => 'Вы действительно хотите удалить эту запись? Это действие нельзя будет отменить.',
    'js_ngrest_rm_confirm' => 'Эта запись была успешно удалена.',
    'js_ngrest_rm_update' => 'Эта запись была успешно обновлена.',
    'js_ngrest_rm_success' => 'Эта запись была успешно сохранена.',
    'js_tag_exists' => 'Тег уже существует.',
    'js_tag_success' => 'Тег сохранен.',
    'js_admin_reload' => 'Система была обновлена. пожалуйста сохраните свои изменения. (Если нажать "отмена" то форма появится снова через 30 секунд.)',
    'js_dir_till' => 'в',
    'js_dir_set_date' => 'Укажите текущую дату',
    'js_dir_table_add_row' => 'Добавить строку',
    'js_dir_table_add_column' => 'Добавить колонку',
    'js_dir_image_description' => 'Описание',
    'js_dir_no_selection' => 'Нет оступных записей. Добавьте новую запись кликнув на <span class="green-text">+</span> ниже слева.',
    'js_dir_image_upload_ok' => 'Изображение успешно добавлено.',
    'js_dir_image_filter_error' => 'Произошла ошибка при применении фильтра.',
    'js_dir_upload_wait' => 'Ваши данные загружаются и обрабатываются. Это может занять несколько минут.',
    'js_dir_manager_upload_image_ok' => 'Файл был успешно загружен.',
    'js_dir_manager_rm_file_confirm' => 'Вы действительно хотите удалить этот файл?',
    'js_dir_manager_rm_file_ok' => 'Файл был успешно удален.',
    'js_zaa_server_proccess' => 'Сервер обрабатывает данные. Пожалуйста подождите',
    
// added translation in 1.0.0-beta4:

    'ngrest_crud_empty_row' => 'Данные пока не добавлены в таблицу',

// added translation in 1.0.0-beta5:

    // aws/gallery
    'aws_gallery_empty' => 'Выберите несколько изображений слева, чтобы добавить их в галерею.',
    'aws_gallery_images' => 'Галерея',
    'layout_useronline_name' => 'Имя',
    'layout_useronline_mail' => 'E-Mail',
    'layout_useronline_inactivesince' => 'Неактивный с',
];
