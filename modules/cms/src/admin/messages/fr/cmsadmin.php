<?php

return [
    
    'view_index_add_type' => 'Type de page',
    'view_index_type_page' => 'Page',
    'view_index_type_module' => 'Module',
    'view_index_type_redirect' => 'Redirection',
    'view_index_as_draft' => 'Comme modèle',
    'view_index_as_draft_help' => 'Voulez-vous définir la nouvelle page en tant que modèle ?',
    'view_index_no' => 'Oui',
    'view_index_yes' => 'Non',
    'view_index_page_title' => 'Titre de la page',
    'view_index_page_alias' => 'Segment de l\'URL',
    'view_index_page_meta_description' => 'Description (Meta Description pour Google)',
    'view_index_page_nav_container' => 'Conteneur de navigation',
    'view_index_page_parent_page' => 'Page parent',
    'view_index_page_success' => 'La page a été créée avec succès',
    'view_index_page_parent_root' => 'au niveau de la racine',
    'view_index_page_use_draft' => 'Utiliser un modèle ?',
    'view_index_page_select_draft' => 'Voulez-vous choisir un modèle ?',
    'view_index_page_layout' => 'Sélection de la mise en page',
    'view_index_page_btn_save' => 'Enregistrer la nouvelle page',
    'view_index_module_select' => 'Nom du module',
    'view_index_redirect_type' => 'Type de renvoi',
    'view_index_redirect_internal' => 'Page interne',
    'view_index_redirect_external' => 'Page externe',
    'view_index_redirect_internal_select' => 'Choisissez la page interne pour la redirection',
    'view_index_redirect_external_link' => 'Lien externe',
    'view_index_redirect_external_link_help' => 'Lien externe commençant avec http:// or https://',
    'view_index_sidebar_new_page' => 'Créer une nouvelle page',
    'view_index_sidebar_drafts' => 'Modèles',
    'view_index_sidebar_move' => 'Déplacer',
    'view_update_drop_blocks' => 'Déposer le conteneur des blocs ici',
    'view_update_blockcontent' => 'Contenu du bloc',
    'view_update_configs' => 'Configurations optionnelles',
    'view_update_settings' => 'Paramètres',
    'view_update_btn_save' => 'Enregistrer',
    'view_update_btn_cancel' => 'Annuler',
    'view_update_holder_state_on' => 'Plier le conteneur',
    'view_update_holder_state_off' => 'Dérouler le conteneur',
    'view_update_is_draft_mode' => 'Edition en mode brouillon',
    'view_update_is_homepage' => 'Page d\'accueil',
    'view_update_properties_title' => 'Propriétés de la page',
    'view_update_no_properties_exists' => 'Aucune propriété n\'a été enregistrée pour cette page',
    'view_update_draft_no_lang_error' => 'Les brouillons n\'ont pas de spécifications linguistiques',
    'view_update_no_translations' => 'Cette page n\'a pas été traduit',
    'view_update_page_is_module' => 'Cette page est un <b>module</b>',
    'view_update_page_is_redirect_internal' => 'Cette page est une <b>redirection interne</b> à <show-internal-redirection nav-id="typeData.value" />',
    'view_update_page_is_redirect_external' => 'Cette page est une <b>redirection externe</b> à <a ng-href="{{typeData.value}}">{{typeData.value}}</a>',
    'menu_node_cms' => 'Contenu de la page',
    'menu_node_cmssettings' => 'Paramètres du CMS',
    'menu_group_env' => 'Environnement',
    'menu_group_item_env_container' => 'Conteneurs',
    'menu_group_item_env_layouts' => 'Dispositions',
    'menu_group_elements' => 'Eléments du contenu',
    'menu_group_item_elements_blocks' => 'Gestion des blocs',
    'menu_group_item_elements_group' => 'Gestion des groupes',
    'btn_abort' => 'Annuler',
    'btn_refresh' => 'Rafraîchir',
    'btn_save' => 'Enregistrer',

    /* added translation in 1.0.0-beta3: */
    'model_navitemmodule_module_name_label' => 'Nom du module',
    'model_navitem_title_label' => 'Titre de la page',
    'model_navitem_alias_label' => 'Segment de l\'URL',
    'model_navitempage_layout_label' => 'Disposition',
    'model_navitemredirect_type_label' => 'Type de redirection',
    'model_navitemredirect_value_label' => 'Cible de redirection',
    'view_index_add_title' => 'Ajouter une nouvelle page',
    'view_index_add_page_from_language' => 'Ajouter la page de la langue',
    'view_index_add_page_from_language_info' => 'Voulez-vous copier le contenu d\'une autre langue lors de la création de cette page ?',
    'view_index_add_page_empty' => 'Ajouter une page vide',
    'view_index_language_loading' => 'Chargement de la page',
    'draft_title' => 'Brouillons',
    'draft_text' => 'Vous pouvez ici, voir et modifier des brouillons existants. Les brouillons peuvent être appliqués lors de la création d\'une nouvelle page.',
    'draft_column_id' => 'ID',
    'draft_column_title' => 'Titre',
    'draft_column_action' => 'Action',
    'draft_edit_button' => 'Modifier',
    'js_added_translation_ok' => 'La traduction de cette page a été créée avec succès',
    'js_added_translation_error' => 'Une erreur est survenue lors de la création de la traduction',
    'js_page_add_exists' => 'La page "%title" existe déjà avec le même URL dans ce groupe (id=%id%)',
    'js_page_property_refresh' => 'Les propriétés ont été mises à jour',
    'js_page_confirm_delete' => 'Voulez-vous vraiment supprimer cette page ?',
    'js_page_delete_error_cause_redirects' => 'Cette page ne peut être supprimé. Vous devez d\'abord supprimer toutes les redirections pointant vers cette page.',
    'js_state_online' => '%title% en ligne',
    'js_state_offline' => '%title% hors ligne',
    'js_state_hidden' => '%title% caché',
    'js_state_visible' => '%title% visible',
    'js_state_is_home' => '%title% est la page racine',
    'js_state_is_not_home' => '%title% n\'est pas la page racine',
    'js_page_item_update_ok' => 'La page «%title%» a été mis à jour',
    'js_page_block_update_ok' => 'Le bloc «%name%» a été mis à jour',
    'js_page_block_remove_ok' => 'Le bloc «%name%» a été mis à jour',
    'js_page_block_visbility_change' => 'La visibilité de «%name%» a été modifié avec succès',

    /* added translation in 1.0.0-beta5: */
    'view_update_blockholder_clipboard' => 'Presse-papiers',

    /* added translation in 1.0.0-beta6: */
    'js_page_block_delete_confirm' => 'Voulez-vous vraiment supprimer le bloc «%name%» ?',
    'view_index_page_meta_keywords' => 'Mots-clés pour l\'analyse SEO (exemple: restaurant, pizza, italy)',
    'current_version' => 'Version en cours',
    'Initial' => 'Première version',
    'view_index_page_version_chooser' => 'Version publiée',
    'versions_selector' => 'Versions',
    'page_has_no_version' => 'Cette page n\'a pas de version et de mise en page. Créer une nouvelle version en cliquant sur l\'icône Ajouter <i class="material-icons green-text">Ajouter</i> sur la droite.',
    'version_edit_title' => 'Version de l\'édition',
    'version_input_name' => 'Nom',
    'version_input_layout' => 'Disposition',
    'version_create_title' => 'Ajouter une nouvelle version',
    'version_create_info' => 'Vous pouvez créer un nombre illimité de versions de pages avec des contenus différents. Publier une version pour la rendre visible sur le site.',
    'version_input_copy_chooser' => 'Version à copier',
    'version_create_copy' => 'Créer une copie d\'une version existante',
    'version_create_new' => 'Créer une nouvelle version vide',
    'js_version_update_success' => 'La version a été mise à jour avec succès',
    'js_version_error_empty_fields' => 'Un ou plusieurs champs sont vides ou ont une valeur non valide',
    'js_version_create_success' => 'La nouvelle version a été enregistré avec succès',

    /* added translation in 1.0.0-beta7: */
    'view_index_create_page_please_choose' => 'Veuillez choisir',
    'view_index_sidebar_autopreview' => 'Aperçu automatique',
    
    /* added translation in 1.0.0-beta8 */
    'module_permission_add_new_page' => 'Créer une nouvelle page',
    'module_permission_update_pages' => 'Modifier la page',
    'module_permission_edit_drafts' => 'Modifier le brouillon',
    'module_permission_page_blocks' => 'Conteneur de blocs de la page',
    'js_version_delete_confirm' => 'Etes-vous sûr de vouloir supprimer la version «%alias%» de la page ?',
    'js_version_delete_confirm_success' => 'La version de la page %alias% a été supprimé avec succès',
    'log_action_insert_cms_nav_item' => 'Ajout d\'un nouvel élément à la langue <b>{info}</b>',
    'log_action_insert_cms_nav' => 'Ajout de la nouvelle page <b>{info}</b>',
    'log_action_insert_cms_nav_item_page_block_item' => 'Insertion d\'un nouveau bloc <b>{info}</b>',
    'log_action_insert_unkown' => 'Insertion d\'une nouvelle ligne',
    'log_action_update_cms_nav_item' => 'Mise à jour de l\'élément de la langue de la page <b>{info}</b>',
    'log_action_update_cms_nav' => 'Mise à jour du statut de la page <b>{info}</b>',
    'log_action_update_cms_nav_item_page_block_item' => 'Mise à jour du contenu ou la configuration du bloc <b>{info}</b>',
    'log_action_update_unkown' => 'Mise à jour d\'une ligne existante',
    'log_action_delete_cms_nav_item' => 'Suppression d\'une version de la langue <b>{info}</b>',
    'log_action_delete_cms_nav' => 'Suppression de la page <b>{info}</b>',
    'log_action_delete_cms_nav_item_page_block_item' => 'Suppression du bloc <b>{info}</b>',
    'log_action_delete_unkown' => 'Supprimer une ligne',
    'block_group_favorites' => 'Favoris',
    'button_create_version' => 'Créer une version',
    'button_update_version' => 'Modifier une version',
    'menu_group_item_env_permission' => 'Permissions de la page',
    
    /* rc1 */
    'page_update_actions_deepcopy_text' => 'Créer une copie de la page en cours comprenant son contenu. Toutes les langues seront copiés mais, seulement la version publiée sera visible.',
    'page_update_actions_deepcopy_btn' => 'Créer une copie',
];
