<?php

return [

    // Blocks

    // AudioBlock
    'block_audio_name' => 'Audio',
    'block_audio_help_soundurl' => 'Fügen Sie hier den Embed Code von soundcloud.com ein.',

    // DevBlock
    'block_dev_name' => 'Design-Tester',

    // FileListBlock
    'block_file_list_name' => 'Dateiliste',
    'block_file_list_files_label' => 'Dateien',
    'block_file_list_files_showtype_label' => 'Dateityp anzeigen?',
    'block_file_list_showtype_yes' => "Ja",
    'block_file_list_showtype_no' => "Nein",

    // FormBlock
    'block_form_name' => 'Formular',
    'block_form_default_name_label' => 'Name',
    'block_form_default_name_placeholder' => 'Vor- und Nachname',
    'block_form_default_name_error' => 'Bitte geben Sie einen Namen ein',
    'block_form_default_email_label' => 'Email',
    'block_form_default_email_placeholder' => 'beispiel@beispiel.ch',
    'block_form_default_email_error' => 'Bitte geben Sie eine Emailadresse ein',
    'block_form_default_message_label' => 'Nachricht',
    'block_form_default_message_error' => 'Bitte geben Sie eine Nachricht ein',
    'block_form_default_send_label' => 'Absenden',
    'block_form_default_send_error' => 'Leider ist ein Fehler beim Senden der Nachricht aufgetreten.',
    'block_form_default_send_success' => 'Vielen Dank! Wir werden uns mit Ihnen in Verbindung setzen.',
    'block_form_default_mail_subject' => 'Kontaktanfrage',

    // HtmlBlock
    'block_html_html_label' => 'HTML-Inhalt',
    'block_html_no_content' => 'Es wurde noch kein HTML Code eingegeben.',

    // ImageBlock
    'block_image_name' => 'Bild',
    'block_image_imageid_label' => 'Bild Upload',
    'block_image_caption_label' => 'Bildunterschrift',
    'block_image_no_image' => 'Es wurde noch kein Bild Hochgeladen.',

    // ImageTextBlock
    'block_image_text_name' => 'Text mit Bild',
    'block_image_text_text_label' => 'Text',
    'block_image_text_imageid_label' => 'Bild Upload',
    'block_image_text_imageposition_label' => 'Bildposition',
    'block_image_text_imageposition_left' => 'Links',
    'block_image_text_imageposition_right' => 'Rechts',
    'block_image_text_heading_label' => 'Überschrift',
    'block_image_text_headingtype_label' => 'Grösse',
    'block_image_text_margin_label' => 'Abstand des Bildes zum Text',
    'block_image_text_margin_pixel' => 'Pixel',
    'block_image_text_texttype_label' => 'Texttyp',
    'block_image_text_texttype_normal' => 'Normaler Text',
    'block_image_text_texttype_markdown' => 'Markdown Text',
    'block_image_text_btnlabel_label' => 'Button Label',
    'block_image_text_btnhref_label' => 'Button Link Adresse',
    'block_image_text_targetblank_label' => 'Link in einem neuen Fenster öffnen',
    'block_image_text_help_texttype' => 'Texttyp bezieht sich ausschliesslich auf den Text und nicht auf die Überschrift.',
    'block_image_text_no_image' => 'Es wurde noch kein Bild Hochgeladen.',
    'block_image_text_no_text' => 'Es wurde noch kein Text angegeben.',

    // LayoutBlock
    'block_layout_name' => 'Layout',
    'block_layout_width_label' => 'Breite der ersten Spalte (maximal 12 Einheiten)',
    'block_layout_placeholders_left' => 'Links',
    'block_layout_placeholders_right' => 'Rechts',

    // LineBlock
    'block_line_name' => 'Linie (Trennung)',
    'block_line_linespace_label' => 'Linien Abstand',
    'block_line_linespace_space' => 'Abstand(Oben/Unten)',
    'block_line_linestyle_label' => 'Linien Style',
    'block_line_linestyle_dotted' => 'Gepunktet',
    'block_line_linestyle_dashed' => 'Gestrichelt',
    'block_line_linestyle_solid' => 'Durchgängig',
    'block_line_linewidth_label' => 'Linien Breite',
    'block_line_linecolor_label' => 'Linien Farbe',

    // LinkButtonBlock
    'block_link_button_name' => 'Link Button',
    'block_link_button_btnlabel_label' => 'Button Label',
    'block_link_button_btnhref_label' => 'Link Adresse',
    'block_link_button_targetblank_label' => 'Link in einem neuen Fenster oder Tag öffnen',
    'block_link_button_simpleLink_label' => 'Als einfachen Link verwenden',

    // ListBlock
    'block_list_name' => 'Auflistung',
    'block_list_elements_label' => 'Elemente',
    'block_list_listtype_label' => 'Typ',
    'block_list_listtype_ul' => 'Auflistung',
    'block_list_listtype_ol' => 'Aufzählung',
    'block_list_no_content' => 'Noch kein Inhalt.',

    // MapBlock
    'block_map_name' => 'Karte',
    'block_map_address_label' => 'Adresse',
    'block_map_zoom_label' => 'Zoom',
    'block_map_zoom_entire' => 'Komplett herausgezoomt',
    'block_map_zoom_world' => 'Welt',
    'block_map_zoom_continent' => 'Kontinent',
    'block_map_zoom_country' => 'Land',
    'block_map_zoom_city' => 'Stadt',
    'block_map_zoom_district' => 'Stadtteil',
    'block_map_zoom_street' => 'Strasse',
    'block_map_zoom_house' => 'Haus',
    'block_map_maptype_label' => 'Kartentyp',
    'block_map_maptype_roadmap' => 'Strassenkarte',
    'block_map_maptype_satellitemap' => 'Satellitenkarte',
    'block_map_maptype_hybrid' => 'Satellitenkarte mit Strassennamen',
    'block_map_no_content' => 'Es wurde noch keine Adresse angegeben.',

    // Module Block
    'block_module_name' => 'Modul',
    'block_module_modulename_label' => 'Modulname',
    'block_module_modulecontroller_label' => 'Controller Name (ohne Controller suffix)',
    'block_module_moduleaction_label' => 'Action Name (ohne action prefix)',
    'block_module_moduleactionargs_label' => 'Action Argumente (json: {"var":"value"})',
    'block_module_no_module' => 'Es wurde noch kein Modul angegeben.',
    'block_module_integration' => 'Modulintegration',

    // QuoteBlock
    'block_quote_name' => 'Zitat',
    'block_quote_content_label' => 'Text',
    'block_quote_no_content' => 'Es wurde noch kein Zitat eingegeben.',

    // SpacingBlock
    'block_spacing_name' => 'Abstand',
    'block_spacing_spacing_label' =>'Abstand',

    // TableBlock
    'block_table_name' => 'Tabelle',
    'block_table_table_label' => 'Text',
    'block_table_header_label' => 'Erste Zeile als Tabellenkopf verwenden',
    'block_table_stripe_label' => 'Jede Zeile abwechselnd hervorheben (Zebramuster)',
    'block_table_border_label' => 'Rand zu jeder Seite der Tabelle hinzufügen',
    'block_table_equaldistance_label' => 'Spaltenabstände gleich gross',
    'block_table_help_table' => 'Es muss zuerst eine Zeile und Spalte hinzugefügt werden, bevor Inhalte eingetragen werden können.',
    'block_table_no_table' => 'Es wurden noch keine Tabellendaten angelegt.',

    // TextBlock
    'block_text_name' => 'Text',
    'block_text_content_label' => 'Text',
    'block_text_texttype_label' =>'Texttyp',
    'block_text_texttype_normal' => 'Normaler Text',
    'block_text_texttype_markdown' => 'Markdown Text',
    'block_text_no_content' => 'Es wurde noch kein Text eingegeben.',

    // TitleBlock
    'block_title_name' => 'Überschrift',
    'block_title_content_label' => 'Titel',
    'block_title_headingtype_label' => 'Grösse',
    'block_title_headingtype_heading' => 'Überschrift',
    'block_title_no_content' => 'Es wurde noch keine Überschrift eingegeben.',

    // VideoBlock
    'block_video_name' => 'Video',
    'block_video_url_label' => 'Video URL',
    'block_video_controls_label' => 'Controls ausblenden?',
    'block_video_help_url' => 'Es werden Vimeo oder Youtube URLs unterstützt.',
    'block_video_help_controls' => 'Diese Option wird momentan nur von Youtube unterstützt.',
    'block_video_no_video' => 'Es wurde noch keine gültige Video URL angegeben.',

    // WysiwygBlock
    'block_wysiwyg_name' => 'Texteditor',
    'block_wysiwyg_content_label' => 'Inhalt',
    'block_wysiwyg_help_content' => 'Klicken Sie in die erste Zeile um mit der Eingabe zu beginnen.',
    'block_wysiwyg_no_content' => 'Es wurde noch kein Text eingegeben.',

    // views/default/index
    
    'view_index_add_type' => 'Seitentyp',
    'view_index_type_page' => 'Seite',
    'view_index_type_module' => 'Modul',
    'view_index_type_redirect' => 'Weiterleitung',
    'view_index_as_draft' => 'Als Vorlage',
    'view_index_as_draft_help' => 'Möchtest du diese neue Seite als Vorlage hinterlegen?',
    'view_index_no' => 'Nein',
    'view_index_yes' => 'Ja',
    'view_index_page_title' => 'Seitentitel',
    'view_index_page_alias' => 'URL Pfadsegment',
    'view_index_page_meta_description' => 'Beschreibung (Meta Description für Google)',
    'view_index_page_nav_container' => 'Navigations-Container',
    'view_index_page_parent_page' => 'Übergeordnete Seite',
    'view_index_page_success' => 'Diese Seite wurde erfolgreich erstellt!',
    'view_index_page_parent_root' => '[Hauptebene]',
    'view_index_page_use_draft' => 'Eine Vorlage verwenden?',
    'view_index_page_select_draft' => 'Möchtest du aus einer Vorlage auswählen?',
    'view_index_page_layout' => 'Layout auswahl',
    'view_index_page_btn_save' => 'Neue Seite speichern',
    'view_index_module_select' => 'Modul Name (Yii-ID)',
    'view_index_redirect_type' => 'Art der Weiterleitung',
    'view_index_redirect_internal' => 'Interne-Seite',
    'view_index_redirect_external' => 'Externe URL',
    'view_index_redirect_internal_select' => 'Wählen Sie die interne Seite, auf die weitergeleitet werden soll.',
    'view_index_redirect_external_link' => 'Externer Link',
    'view_index_redirect_external_link_help' => 'Externe Links beginnen mit http:// oder https://',
    
    'view_index_sidebar_new_page' => 'Neue Seite erstellen',
    'view_index_sidebar_drafts' => 'Vorlagen',
    'view_index_sidebar_move' => 'Verschieben',
    
    // view_update
    
    'view_update_drop_blocks' => 'Inhaltsblöcke hier platzieren',
    'view_update_blockcontent' => 'Block content',
    'view_update_settings' => 'Einstellungen',
    'view_update_configs' => 'Optionale Konfiguration',
    'view_update_btn_save' => 'Speichern',
    'view_update_btn_cancel' => 'Abbrechen',
    'view_update_holder_state_on' => 'Platzhalter einklappen',
    'view_update_holder_state_off' => 'Platzhalter ausklappen',
    'view_update_is_draft_mode' => 'Sie sind im Seiten-Vorlage Modus.',
    'view_update_is_homepage' => 'Startseite',
    'view_update_properties_title' => 'Seiten Eigenschaften',
    'view_update_no_properties_exists' => 'Es wurden noch keine Eigenschaften für diese Seite gespeichert.',
    'view_update_draft_no_lang_error' => 'Vorlagen haben keine Sprach spezifikation.',
    'view_update_no_translations' => 'Diese Seite wurde noch nicht übersetzt.',
    'view_update_page_is_module' => 'Diese Seite ist als <b>Module</b> hinterlegt.',
    'view_update_page_is_redirect_internal' => 'Diese Seite ist ein <b>interner Redirect</b> auf <show-internal-redirection nav-id="typeData.value" />.',
    'view_update_page_is_redirect_external' => 'Diese Seite ist ein <b>externer Redirect</b> auf <a ng-href="{{typeData.value}}">{{typeData.value}}</a>',
    
    // menu
    
    'menu_node_cms' => 'Seiteninhalte',
    'menu_node_cmssettings' => 'CMS-Einstellungen',
    'menu_group_env' => 'Umgebung',
    'menu_group_item_env_container' => 'Container',
    'menu_group_item_env_layouts' => 'Layouts',
    'menu_group_elements' => 'Inhaltselemente',
    'menu_group_item_elements_blocks' => 'Verwalten',
    'menu_group_item_elements_group' => 'Gruppen',
   
    // global
    
    'btn_abort' => 'Abbrechen',
    'btn_refresh' => 'Aktualisieren',
    'btn_save' => 'Speichern',

// added translation in 1.0.0-beta3:

    // NavItemModule
    'model_navitemmodule_module_name_label' => 'Modul Name',

    // NavItem
    'model_navitem_title_label' => 'Seitentitel',
    'model_navitem_alias_label' => 'Pfadsegment',

    // NavItemPage
    'model_navitempage_layout_label' => 'Layout',

    // NavItemRedirect
    'model_navitemredirect_type_label' => 'Art der Weiterleitung',
    'model_navitemredirect_value_label' => 'Ziel der Weiterleitung',
    
    // missing from LineBlock
    'block_line_linecolor_grey' => 'Grau',
    'block_line_linecolor_black' => 'Schwarz',
];

