<?php

return [

    'view_index_add_type' => 'Tipo de página',
    'view_index_type_page' => 'Página',
    'view_index_type_module' => 'Módulo',
    'view_index_type_redirect' => 'Redirección',
    'view_index_as_draft' => 'Como plantilla',
    'view_index_as_draft_help' => '¿Desea definir la nueva página como una plantilla?',
    'view_index_no' => 'No',
    'view_index_yes' => 'Sí',
    'view_index_page_title' => 'Título de la página',
    'view_index_page_alias' => 'Alias',
    'view_index_page_meta_description' => 'Descripción (Meta Descripción para motores de búsqueda)',
    'view_index_page_nav_container' => 'Contenedor de navegación',
    'view_index_page_parent_page' => 'Página padre',
    'view_index_page_success' => 'Página creada con éxito!',
    'view_index_page_parent_root' => '[Nivel principal]',
    'view_index_page_use_draft' => '¿Utiliza una plantilla?',
    'view_index_page_select_draft' => '¿Desea elegir una plantilla?',
    'view_index_page_layout' => 'Elegir diseño',
    'view_index_page_btn_save' => 'Guardar nueva página',
    'view_index_module_select' => 'Nombre del módulo',
    'view_index_sidebar_new_page' => 'Crear nueva página',
    'view_index_sidebar_drafts' => 'Plantillas',
    'view_index_sidebar_move' => 'Movimiento',
    'view_update_drop_blocks' => 'Arrastre el contenido del bloque aquí',
    'view_update_blockcontent' => 'Bloque de contenido',
    'view_update_configs' => 'Configuraciones opcionales',
    'view_update_settings' => 'Ajustes',
    'view_update_btn_save' => 'Guardar',
    'view_update_btn_cancel' => 'Cancelar',
    'view_update_holder_state_on' => 'Ocultar',
    'view_update_holder_state_off' => 'Desplegar',
    'view_update_is_draft_mode' => 'Editarlo como un proyecto.',
    'view_update_is_homepage' => 'Página principal',
    'view_update_properties_title' => 'Propiedades de la página',
    'view_update_no_properties_exists' => 'No se guardaron todas las propiedades de esta página.',
    'view_update_draft_no_lang_error' => 'Los borradores no tiene datos específicos de idioma.',
    'view_update_no_translations' => 'Esta página todavía no ha sido traducida.',
    'view_update_page_is_module' => 'Esta página es un <b>módulo</b>.',
    'view_update_page_is_redirect_internal' => 'Esta página tiene un <b>redireccionamiento interno</b> de <show-internal-redirection nav-id="typeData.value" />.',
    'view_update_page_is_redirect_external' => 'Esta página tiene un <b>redireccionamiento externo</b> de <a ng-href="{{typeData.value}}">{{typeData.value}}</a>',
    'menu_node_cms' => 'Contenido de página',
    'menu_node_cmssettings' => 'Configuración del CMS',
    'menu_group_env' => 'Entorno',
    'menu_group_item_env_container' => 'Contenedores',
    'menu_group_item_env_layouts' => 'Diseños',
    'menu_group_elements' => 'Elementos de contenido',
    'menu_group_item_elements_blocks' => 'Gestión de bloques',
    'menu_group_item_elements_group' => 'Gestión de grupos',
    'btn_abort' => 'Cancelar',
    'btn_refresh' => 'Actualizar',
    'btn_save' => 'Guardar',

// added translation in 1.0.0-beta3:

    'model_navitemmodule_module_name_label' => 'Nombre del módulo',
    'model_navitem_title_label' => 'Título de página',
    'model_navitem_alias_label' => 'Ruta URL',
    'model_navitempage_layout_label' => 'Diseño',
    'model_navitemredirect_type_label' => 'Tipo de redirección',
    'model_navitemredirect_value_label' => 'Objetivo de redirección',

    'view_index_add_title' => 'Añadir nueva página',
    'view_index_add_page_from_language' => 'Añadir página de idioma',
    'view_index_add_page_from_language_info' => '¿Le gustaría copiar el contenido de otro idioma al crear esta página?',
    'view_index_add_page_empty' => 'Añadir nueva página en blanco',
    'view_index_language_loading' => 'Cargando página',
    'draft_title' => 'Borradores',
    'draft_text' => 'Aquí se puede ver y editar los borradores existentes. Los borradores se pueden aplicar al crear una nueva página.',
    'draft_column_id' => 'ID',
    'draft_column_title' => 'Título',
    'draft_column_action' => 'Acción',
    'draft_edit_button' => 'Editar',
    'js_added_translation_ok' => 'La traducción de esta página se ha creado correctamente.',
    'js_added_translation_error' => 'Se ha producido un error al crear la traducción',
    'js_page_add_exists' => 'Ya existe una página "%title" con la misma URL en este grupo (id=%id%).',
    'js_page_property_refresh' => 'Las propiedades fueron actualizadas.',
    'js_page_confirm_delete' => '¿Está seguro de eliminar esta página?',
    'js_page_delete_error_cause_redirects' => 'No puede eliminar esta página. Primero debe eliminar todas las redirecciones a esta página.',
    'js_state_online' => '%title% en línea',
    'js_state_offline' => '%title% desconectado',
    'js_state_hidden' => '%title% oculto',
    'js_state_visible' => '%title% visible',
    'js_state_is_home' => '%title% es la página raíz',
    'js_state_is_not_home' => '%title% no es la página raíz',
    'js_page_item_update_ok' => 'La página de «%title%», ha sido actualizada!',
    'js_page_block_update_ok' => 'El bloque «%name%», a sido actualizado!',
    'js_page_block_remove_ok' => 'El bloque «%name%», a sido eliminado!',
    'js_page_block_visbility_change' => 'La visibilidad de «%name%», se cambió correctamente.',

// added translation in 1.0.0-beta4:

// added translation in 1.0.0-beta5:


    'view_update_blockholder_clipboard' => 'Portapapeles',

// added translation in 1.0.0-beta6:


    'js_page_block_delete_confirm' => '¿Desea borrar el bloque «%name%»?',
    'view_index_page_meta_keywords' => 'Palabra clave de análisis de SEO (ejemplo: restaurante, pizza, Italia)',
    'current_version' => 'Versión actual',
    'Initial' => 'Versión inicial',
    'view_index_page_version_chooser' => 'Versión publicada',
    'versions_selector' => 'Versiones',
    'page_has_no_version' => 'Esta página no tiene ninguna versión y ningún diseño todavía. Crear una nueva versión pulsando en el icono de añadir <i class="material-icons green-text">add</i> a la derecha.',
    'version_edit_title' => 'Editar versión',
    'version_input_name' => 'Nombre',
    'version_input_layout' => 'Diseño',
    'version_create_title' => 'Añadir nueva versión',
    'version_create_info' => 'Puede crear cualquier número de versiones de la página con diferentes contenidos. Publicar una versión para que sea visible en el sitio web.',
    'version_input_copy_chooser' => 'Versión para copiar',
    'version_create_copy' => 'Crear una copia de una versión existente.',
    'version_create_new' => 'Crear una nueva versión, vacía.',
    'js_version_update_success' => 'La versión se ha actualizado correctamente.',
    'js_version_error_empty_fields' => 'Uno o más campos están vacíos o tienen un valor no válido.',
    'js_version_create_success' => 'La nueva versión ha sido guardada con éxito.',

// added translation in 1.0.0-beta7:


    'view_index_create_page_please_choose' => 'Por favor seleccione',
    'view_index_sidebar_autopreview' => 'Vista previa',

// added translation in 1.0.0-beta8

    'module_permission_add_new_page' => 'Crear nueva página',
    'module_permission_update_pages' => 'Editar página',
    'module_permission_edit_drafts' => 'Editar borrador',
    'module_permission_page_blocks' => 'Bloques página de contenido',
    'js_version_delete_confirm' => '¿Está seguro de borrar la versión de página «%alias%»?',
    'js_version_delete_confirm_success' => 'La versión de la página %alias% se ha eliminado correctamente.',
    'log_action_insert_cms_nav_item' => 'Añadir nuevo elemento de idioma <b>{info}</b>',
    'log_action_insert_cms_nav' => 'Added new page <b>{info}</b>',
    'log_action_insert_cms_nav_item_page_block_item' => 'Inserted a new block <b>{info}</b>',
    'log_action_insert_unkown' => 'Added a new row',
    'log_action_update_cms_nav_item' => 'Actualizar el elemento de idiomas de la página <b>{info}</b>',
    'log_action_update_cms_nav' => 'Actualizar del estado de la página <b>{info}</b>',
    'log_action_update_cms_nav_item_page_block_item' => 'Actualizar el contenido o la configuración del bloque de <b>{info}</b>',
    'log_action_update_unkown' => 'Actualizar una fila existente',
    'log_action_delete_cms_nav_item' => 'Quitar la versión de idioma de <b>{info}</b>',
    'log_action_delete_cms_nav' => 'Eliminar página <b>{info}</b>',
    'log_action_delete_cms_nav_item_page_block_item' => 'Eliminar bloque <b>{info}</b>',
    'log_action_delete_unkown' => 'Eliminar una fila',
    'block_group_favorites' => 'Favoritos',
    'button_create_version' => 'Crear versión',
    'button_update_version' => 'Actualizar versión',
    'menu_group_item_env_permission' => 'Permisos de página',

// rc1

    'page_update_actions_deepcopy_text' => 'Crear una copia de la página actual con todo su contenido. Todos los idiomas se copiarán, pero sólo la versión publicada.',
    'page_update_actions_deepcopy_btn' => 'Crear copia',
    
// rc2
    'model_navitem_title_tag_label' => 'Title Tag (SEO)',
    
// 1.0.0
    'model_navitempage_empty_draft_id' => 'Unable to create page from empty draft template.',
];
