<?php
use luya\admin\Module as Admin;
use luya\helpers\Url;
use yii\helpers\Markdown;

$user = Yii::$app->adminuser->getIdentity();
$this->beginPage()
?><!DOCTYPE html>
<html ng-app="zaa" ng-controller="LayoutMenuController">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= Yii::$app->siteTitle; ?> &rsaquo; {{currentItem.alias}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= Url::base(true); ?>/admin" />
    <style type="text/css">
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
  			display: none !important;
		}
		
		.dragover {
		    border: 5px dashed #2196F3;
		}
    </style>
    <?php $this->head(); ?>
</head>
<body ng-cloak flow-prevent-drop>
<?php $this->beginBody(); ?>
<div class="loading-overlay" ng-if="LuyaLoading.getState()">
    <div class="loading-overlay__content">
        <h3 class="loading-overlay__title">
            {{LuyaLoading.getStateMessage()}}
        </h3>

        <div class="loading-overlay__loader">
            <div class="loading-indicator">
                <div class="rect1"></div><!--
                --><div class="rect2"></div><!--
                --><div class="rect3"></div><!--
                --><div class="rect4"></div><!--
                --><div class="rect5"></div>
            </div>
        </div>
    </div>
</div>


<script type="text/ng-template" id="modal">
    <div class="modal__wrapper" ng-show="!isModalHidden" zaa-esc="isModalHidden=1" >
        <div class="modal">
            <button type="button" class="btn waves-effect waves-light modal__close btn-floating red" ng-click="isModalHidden=1">
                <i class="material-icons">close</i>
            </button>
            <div class="modal-content" ng-transclude></div>
        </div>
        <div class="modal__background" ng-click="isModalHidden=1" style="cursor:pointer;"></div>
    </div>
</script>

<!-- UPDATE REDIRECT FORM -->
<script type="text/ng-template" id="updateformredirect.html">
    <div class="row">
        <div class="input input--radios col s12">
            <label class="input__label"><?= Admin::t('view_index_redirect_type'); ?></label>
            <div class="input__field-wrapper">
                <input type="radio" ng-model="data.type" ng-value="1"><label ng-click="data.type = 1"><?= Admin::t('view_index_redirect_internal'); ?></label> <br />
                <input type="radio" ng-model="data.type" ng-value="2"><label ng-click="data.type = 2"><?= Admin::t('view_index_redirect_external'); ?></label>
            </div>
        </div>
    </div>

    <div class="row" ng-switch on="data.type">
        <div class="col s12" ng-switch-when="1">
            <p><?= Admin::t('view_index_redirect_internal_select'); ?></p>
            <menu-dropdown class="menu-dropdown" nav-id="data.value" />
        </div>

        <div class="col s12" ng-switch-when="2">

            <div class="input input--text col s12">
                <label class="input__label"><?= Admin::t('view_index_redirect_external_link'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.value" placeholder="http://" />
                    <small><?= Admin::t('view_index_redirect_external_link_help'); ?></small>
                </div>
            </div>
        </div>
    </div>
</script>
<!-- /UPDATE REDIRECT FORM -->

<script type="text/ng-template" id="menuDropdownReverse">

    <div class="input">
        <input type="radio" ng-checked="data.id == navId" />
        <label ng-click="changeModel(data)">
            <span class="menu-dropdown__label">{{ data.title }}</span>
        </label>
    </div>

    <ul class="menu-dropdown__list">
        <li class="menu-dropdown__item" ng-repeat="data in menuData.items | menuparentfilter:container.id:data.id" ng-include="'menuDropdownReverse'"></li>
    </ul>
</script>

<script type="text/ng-template" id="storageFileUpload">
    <div class="link-selector">
        <div class="link-selector__btn btn-flat [ grey lighten-4 ]" ng-click="toggleModal()">
            <i class="material-icons left">attach_file</i>
                    <span>
                        <?= Admin::t('layout_select_file'); ?>
                    </span>
        </div>
        <span class="link-selector__reset" ng-click="reset()" ng-show="fileinfo!=null"><i class="material-icons">remove_circle</i></span>
        <span class="link-selector__path" ng-bind="fileinfo.name"></span>
        <div ng-if="!modal.state">
        <modal is-modal-hidden="modal.state"><storage-file-manager selection="true" /></modal>
        </div>
    </div>
</script>

<script type="text/ng-template" id="storageImageUpload">
    <div class="imageupload">
        <div ng-if="imageNotFoundError" class="alert alert--danger" style="margin-top:0px;">The requested image id ({{ngModel}}) could not be found anymore. The orignal file has been deleted in the filemanager!</div>
        <storage-file-upload ng-model="fileId"></storage-file-upload>
        <div ng-show="originalFileIsRemoved">
            <div class="alert alert--danger"><?= Admin::t('layout_deleted_file'); ?></div>
        </div><!--
        --><div class="imageupload__preview" ng-show="imageinfo != null">
            <img ng-src="{{thumb.source}}" ng-show="imageinfo != null" class="responsive-img" />
            <div class="imageupload__size" ng-show="!imageLoading">{{ imageinfo.resolutionWidth }} x {{ imageinfo.resolutionHeight }}</div>
            <div class="imageupload__loading" ng-hide="!imageLoading">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-green-only">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                            <div class="circle"></div>
                        </div><div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="imageupload__filter" ng-show="!noFilters() && imageinfo != null">
            <label><?= Admin::t('layout_image_filter_selection'); ?></label>
            <select name="filterId" ng-model="filterId" convert-to-number><option value="0"><?= Admin::t('layout_no_filter'); ?></option><option ng-repeat="item in filtersData" value="{{ item.id }}">{{ item.name }} ({{ item.identifier }})</option></select>
        </div>

    </div>
</script>

<script type="text/ng-template" id="reverseFolders">

    <i class="material-icons treeview__toggler filemanager__folder-toggleicon" ng-click="toggleFolderItem(folder)" ng-hide="folder.subfolder==0" ng-class="{'treeview__toggler--subnav-closed': folder.toggle_open!=1}">arrow_drop_down</i>
    <div class="filemanager__folder-button" ng-click="changeCurrentFolderId(folder.id)" tooltip tooltip-expression="folderCountMessage(folder)" tooltip-offset-top="-5">
        <i class="material-icons filemanager__folder-icon filemanager__folder-icon--default"></i>
        <i class="material-icons filemanager__folder-icon filemanager__folder-icon--active"></i>
                        <span class="filemanager__folder-name" ng-hide="folderUpdateForm && currentFolderId==folder.id">
                            {{folder.name }}                                            
                        </span>
                        <i class="material-icons filemanager__edit-icon" ng-click="toggleFolderMode('edit')">mode_edit</i>
                        <i class="material-icons filemanager__delete-icon" ng-click="toggleFolderMode('remove')">delete</i>
                        
                        <span ng-if="folderUpdateForm && currentFolderId==folder.id">
                            <input type="text" ng-model="folder.name" class="filemanager__file-dialog__input"/>
                            <div class="filemanager__file-dialog">
                                <span><?= Admin::t('layout_filemanager_save_dir'); ?></span>
                                <div class="filemanager__file-dialog--buttons">
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager__file-dialog__icon" ng-click="updateFolder(folder)">check</i>
                                    </span>
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager__file-dialog__icon filemanager__cancel-icon" ng-click="toggleFolderMode(false)">add</i>
                                    </span>
                                </div>                                
                            </div>
                        </span>
                        <i class="material-icons filemanager__file-move-icon" ng-click="moveFilesTo(folder.id)" ng-show="showFoldersToMove && currentFolderId != folder.id">keyboard_return</i>
                        <span ng-if="folderDeleteForm && currentFolderId==folder.id">
                            <div class="filemanager__file-dialog">
                                <span><?= Admin::t('layout_filemanager_remove_dir'); ?></span>
                                <div class="filemanager__file-dialog--buttons">
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager__file-dialog__icon" ng-click="checkEmptyFolder(folder)">check</i>
                                    </span>
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager__file-dialog__icon filemanager__cancel-icon" ng-click="toggleFolderMode(false)">add</i>
                                    </span>
                                </div>
                            </div>
                        </span>

                        <span ng-if="folderDeleteConfirmForm && currentFolderId==folder.id">
                            <div class="filemanager__file-dialog">
                                <span><?= Admin::t('layout_filemanager_remove_dir_not_empty'); ?></span>
                                <div class="filemanager__file-dialog--buttons">
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager__file-dialog__icon" ng-click="deleteFolder(folder)">check</i>
                                    </span>
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager__file-dialog__icon filemanager__cancel-icon" ng-click="toggleFolderMode(false)">add</i>
                                    </span>
                                </div>
                            </div>
                        </span>

        <!-- mdi-mdi-action-highlight-remove -->
    </div>
    <ul class="filemanager__folders" ng-show="folder.toggle_open==1">
        <li class="filemanager__folder"  ng-class="{'filemanager__folder--active' : currentFolderId == folder.id, 'filemanager__folder--has-subfolders': folder.__items.length > 0}" ng-repeat="folder in foldersData | toArray:false | orderBy:'name' | filemanagerdirsfilter:folder.id"  ng-include="'reverseFolders'"></li>
    </ul>
</script>

<!-- FILEMANAGER -->
<script type="text/ng-template" id="storageFileManager">

    <div class="filemanager" ng-paste="pasteUpload($event)">

        <!-- TREE -->
        <div class="filemanager__tree">

            <div class="filemanager__toolbar filemanager__toolbar--top">

                <div class="floating-form left" ng-class="{ 'floating-form--active' : showFolderForm }">
                    <div class="floating-form__form">
                        <input class="floating-form__input" type="text" ng-model="newFolderName" id="foldername" placeholder="<?= Admin::t('layout_filemanager_folder'); ?>" />
                    </div><!-- PREVENT WHITESPACE
                         --><div class="floating-form__actions">
                        <span class="[ floating-form__button floating-form__button--active ] btn-floating" ng-click="createNewFolder(newFolderName)"><i class="material-icons">check</i></span>
                        <span class="floating-form__button floating-form__button--active-close btn-floating" ng-click="folderFormToggler()"><i class="material-icons">add</i></span>
                    </div><!-- PREVENT WHITESPACE
                         --><span class="floating-form__label" ng-click="folderFormToggler()"><?= Admin::t('layout_filemanager_add_folder'); ?></span>
                </div>

            </div>

            <!-- FOLDER LIST -->
            <ul class="filemanager__folders">
                <li class="filemanager__folder filemanager__folder--root" ng-class="{'filemanager__folder--active' : currentFolderId == 0 }">
                    <div class="filemanager__folder-button folder-root" ng-click="changeCurrentFolderId(0)">
                        <i class="material-icons filemanager__folder-icon filemanager__folder-icon--root"></i>
                        <span class="filemanager__folder-name"><?= Admin::t('layout_filemanager_root_dir'); ?></span>
                    </div>
                    <ul class="filemanager__folders">
                        <li class="filemanager__folder" ng-class="{'filemanager__folder--active' : currentFolderId == folder.id}" ng-repeat="folder in foldersData | toArray:false | orderBy:'name' | filemanagerdirsfilter:0" ng-include="'reverseFolders'"></li>
                    </ul>
                </li>
            </ul>
            <!-- /FOLDER LIST -->

        </div><!--/TREE

                FILES & FOLDERS
             --><div class="filemanager__files">

            <div class="filemanager__toolbar filemanager__toolbar--top">

                <label class="floating-button-label left" ngf-enable-firefox-paste="true" ngf-drag-over-class="'dragover'" ngf-drop ngf-select ngf-multiple="true" ng-model="uploadingfiles">
                            <span class="btn-floating">
                                <i class="material-icons">file_upload</i>
                            </span>
                    <span class="floating-button-label__label"><?= Admin::t('layout_filemanager_upload_files'); ?></span>
                </label>

                <div class="filemanager__search input input--text">
                    <div class="input__field-wrapper">
                        <input class="input__field filemanager__search-input" type="text" ng-model="searchQuery" placeholder="<?= Admin::t('layout_filemanager_search_text') ?>" />
                    </div>
                </div>

                <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="removeFiles()"><b>{{selectedFiles.length}}</b> <?= Admin::t('layout_filemanager_remove_selected_files'); ?></button>
                <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="showFoldersToMove=!showFoldersToMove"><?= Admin::t('layout_filemanager_move_selected_files'); ?></button>

            </div>

            <div class="row">

            <div class="filemanager__col col" ng-class="{'filemanager__col--file-details' : fileDetail, 's12' : !fileDetail }">
            <table class="filemanager__table hoverable striped">
                <thead>
                    <tr>
                        <th class="filemanager__checkox-column" ng-hide="allowSelection == 'true'">
                            <i class="material-icons clickable" ng-click="toggleSelectionAll()">done_all</i>
                        </th>
                        <th ng-if="selectedFileFromParent" style="width:15px;"></th>
                        <th></th>
                        <th><?= Admin::t('layout_filemanager_col_name'); ?><i ng-click="changeSortField('name')" ng-class="{'active-orderby' : sortField == 'name' }" class="material-icons grid-sort-btn">keyboard_arrow_up</i> <i ng-click="changeSortField('-name')" ng-class="{'active-orderby' : sortField == '-name' }" class="material-icons grid-sort-btn">keyboard_arrow_down</i></th>
                        <th><?= Admin::t('layout_filemanager_col_type'); ?><i ng-click="changeSortField('extension')" ng-class="{'active-orderby' : sortField == 'extension' }" class="material-icons grid-sort-btn">keyboard_arrow_up</i> <i ng-click="changeSortField('-extension')" ng-class="{'active-orderby' : sortField == '-extension' }" class="material-icons grid-sort-btn">keyboard_arrow_down</i></th>
                        <th><?= Admin::t('layout_filemanager_col_date'); ?><i ng-click="changeSortField('uploadTimestamp')" ng-class="{'active-orderby' : sortField == 'uploadTimestamp' }" class="material-icons grid-sort-btn">keyboard_arrow_up</i> <i ng-click="changeSortField('-uploadTimestamp')" ng-class="{'active-orderby' : sortField == '-uploadTimestamp' }" class="material-icons grid-sort-btn">keyboard_arrow_down</i></th>
                        <th><?= Admin::t('layout_filemanager_col_size'); ?><i ng-click="changeSortField('size')" ng-class="{'active-orderby' : sortField == 'size' }" class="material-icons grid-sort-btn">keyboard_arrow_up</i> <i ng-click="changeSortField('-size')" ng-class="{'active-orderby' : sortField == '-size' }" class="material-icons grid-sort-btn">keyboard_arrow_down</i></th>
                    </tr>
                </thead>
                <tbody>

                <!-- FILES -->
                <tr 
                    ng-repeat="file in filesData | filemanagerfilesfilter:currentFolderId:onlyImages:searchQuery | filter:searchQuery | orderBy:sortField" 
                    alt="fileId={{file.id}}" 
                    title="fileId={{file.id}}" 
                    class="filemanager__file" 
                    ng-class="{ 'clickable selectable' : allowSelection == 'false', 'filemanager__file--selected': selectedFileFromParent && selectedFileFromParent.id == file.id}">

                    <td ng-click="toggleSelection(file)" class="filemanager__checkox-column" ng-hide="allowSelection == 'true'">
                        <input type="checkbox" ng-checked="inSelection(file)" id="{{file.id}}" />
                        <label for="checked-status-managed-by-angular-{{file.id}}"></label>
                    </td>
                    <td ng-if="selectedFileFromParent">
                        <i class="material-icons" ng-if="selectedFileFromParent.id == file.id">check_box</i>
                    </td>
                    <td ng-click="toggleSelection(file)" class="filemanager__icon-column" ng-class="{ 'filemanager__icon-column--thumb' : file.isImage }">
                        <span ng-if="file.isImage"><img class="responsive-img filmanager__thumb" ng-src="{{file.thumbnail.source}}" /></span>
                        <span ng-if="!file.isImage"><i class="material-icons">attach_file</i></span>
                    </td>
                    <td ng-click="toggleSelection(file)">{{file.name}}</td>
                    <td class="filemanager__lighten">{{file.extension}}</td>
                    <td class="filemanager__lighten">{{file.uploadTimestamp * 1000 | date:"short"}}</td>
                    <td class="filemanager__ligthen">{{file.sizeReadable}}</td>
                    <td class="filemanager__lighten" ng-click="openFileDetail(file)"><i class="material-icons">zoom_in</i></td>
                </tr>
                <!-- /FILES -->

                </tbody>
            </table>
            </div>
            <div class="filemanager__details" ng-show="fileDetail">
                <div class="filemanager__details-bar">
                    <a ng-href="{{fileDetail.source}}" target="_blank" class="btn btn--small"><?= Admin::t('layout_filemanager_detail_download'); ?></a>
                    <button type="button" class="btn btn--small" type="file" ngf-keep="false" ngf-select="replaceFile($file, $invalidFiles)"><?= Admin::t('layout_filemanager_detail_replace_file'); ?></button>
                    <a class="filemanager__details-close btn red btn-floating right" ng-click="closeFileDetail()"><i class="material-icons">close</i></a>
                </div>

                <table class="filemanager__details-table filemanager__table">
                    <tbody>
                        <tr>
                            <td><b><?= Admin::t('layout_filemanager_detail_name'); ?></b></td><td>{{ fileDetail.name }}</td>
                        </tr>
                        <tr>
                            <td><b><?= Admin::t('layout_filemanager_detail_date'); ?></b></td><td>{{fileDetail.uploadTimestamp * 1000 | date:"dd.MM.yyyy, HH:mm"}} Uhr</td>
                        </tr>
                        <tr>
                            <td><b><?= Admin::t('layout_filemanager_detail_filetype'); ?></b></td><td>{{ fileDetail.extension }}</td>
                        </tr>
                        <tr>
                            <td><b><?= Admin::t('layout_filemanager_detail_size'); ?></b></td><td>{{ fileDetail.sizeReadable }}</td>
                        </tr>
                        <tr>
                            <td><b><?= Admin::t('layout_filemanager_detail_id'); ?></b></td><td>{{ fileDetail.id }}</td>
                        </tr>
                    </tbody>
                </table>

                <span ng-if="fileDetail.isImage">
                    <img class="responsive-img" ng-src="{{fileDetail.thumbnailMedium.source}}" />
                </span>

                <div class="filemanager__details-panel clearfix">
                    <strong><?= Admin::t('layout_filemanager_file_captions'); ?></strong>
                    <div class="input input--text input--vertical" ng-repeat="(key, cap) in fileDetail.captionArray">
                        <span class="flag flag--{{key}}"><span class="flag__fallback flag__fallback--colorized">{{key}}</span></span>
                        <div class="input__field-wrapper">
                            <input class="input__field" id="id-{{key}}" name="{{key}}" type="text" ng-model="fileDetail.captionArray[key]" />
                        </div>
                    </div>
                    <button type="button" class="filemanager__detail-save-button btn btn--small right" ng-click="storeFileCaption(fileDetail)"><?= Admin::t('layout_filemanager_file_captions_save_btn'); ?></button>
                </div>
        </div>
        <!-- FILES & FOLDERS -->

        <div class="filemanager__toolbar filemanager__toolbar--bottom">

            <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="removeFiles()"><b>{{selectedFiles.length}}</b> <?= Admin::t('layout_filemanager_remove_selected_files'); ?></button>
            <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="showFoldersToMove=!showFoldersToMove"><?= Admin::t('layout_filemanager_move_selected_files'); ?></button>

        </div>
    </div>

</script>
<!-- /FILEMANAGER -->

<!-- /ANGULAR SCRIPTS -->

<div class="luya-container ng-cloak" ng-class="{'luya-container--right-panel-active': sidePanelHelp}">
    <div class="toasts" ng-if="toastQueue" ng-repeat="item in toastQueue">
        <div class="toasts__confirm" ng-if="item.type == 'confirm'" zaa-esc="item.close()">
            <div class="toasts__item toasts__item--confirm">
                <p>{{item.message}}</p>
                <div class="toasts__item-buttons">
                    <button type="button" class="btn btn--small grey" ng-click="item.close()"><?= Admin::t('button_abort'); ?></button>
                    <button type="button" class="btn btn--small red" ng-click="item.click()"><?= Admin::t('button_confirm'); ?></button>
                </div>
            </div>
        </div>
        <div class="toasts__info" ng-if="item.type != 'confirm'">
            <div class="toasts__item" ng-class="{'toasts__item--success': item.type == 'success', 'toasts__item--error': item.type == 'error', 'toasts__item--confirm': item.type == 'confirm'}" style="transform: translateY(-{{ ($index * 120) }}%);">
                <i class="toasts__text-icon material-icons" ng-show="item.type == 'success'">check_circle</i>
                <i class="toasts__text-icon material-icons" ng-show="item.type == 'error'">error_outline</i>
                <p class="toasts__text">{{item.message}}</p>
            </div>
        </div>
    </div>

    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper blue">
                <a style="cursor: pointer;" data-activates="mobile-demo" class="button-collapse" ng-click="mobileOpen = !mobileOpen"><i class="material-icons">menu</i></a>

                <ul class="left hide-on-med-and-down">
                    <li class="navbar__item"><a ng-href="#"><i class="material-icons navbar__icon">home</i></a></li>
                    <li class="navbar__item" ng-repeat="item in items" ng-class="{'navbar__item--active' : isActive(item) }">
                        <a ng-click="click(item);" class="navbar__link"><i class="material-icons navbar__icon">{{item.icon}}</i>{{item.alias}}</a>
                    </li>
                </ul>



                <div class="iconbar__wrapper">
                    <div class="iconbar" ng-class="{ 'iconbar--slided' : iconbarOpen }">
                        <ul class="right navbar__right">
                            <li class="toggler">
                                <a class="toggler__link" ng-click="iconbarOpen=!iconbarOpen"><i class="material-icons">keyboard_arrow_right</i></a>
                            </li>
                            <?= $this->render('_iconbar'); ?>
                        </ul>
                    </div>
                    <span class="toggler toggler--hidden right">
                        <a class="toggler__link" ng-click="iconbarOpen=!iconbarOpen"><i class="material-icons">keyboard_arrow_left</i></a>
                    </span>
                </div>

                <ul class="side-nav" id="mobile-demo" ng-class="{ 'side-nav--open' : mobileOpen }">
                    <li ng-repeat="item in items" ng-class="{'active' : isActive(item) }">
                        <a ng-click="click(item);" class="navbar__link"><i class="[ material-icons left ] navbar__icon">{{item.icon}}</i>{{item.alias}}</a>
                    </li>
                </ul>

                <div class="navbar__search-wrapper" ng-class="{ 'navbar__search-wrapper--wide' : searchInputOpen }">
                    <div class="input-field navbar__search" ng-class="{ 'navbar__search--open' : searchInputOpen }">
                        <input id="global-search-input" ng-model="searchQuery" type="search" class="navbar__search-input" ng-show="searchInputOpen">
                        <label for="global-search-input" class="navbar__search-label" ng-click="openSearchInput()"><i class="material-icons">search</i></label>
                        <i class="material-icons navbar__search-icon" ng-click="closeSearchInput()">close</i>
                    </div>
                </div>
            </div>
        </nav>
    </div> <!-- /navbar-fixed -->

    <div ng-if="showDebugContainer" class="debug-container">
        <table class="bordered">
            <thead>
            <tr>
                <th><?= Admin::t('layout_debug_table_key'); ?></th>
                <th><?= Admin::t('layout_debug_table_value'); ?></th>
            </tr>
            </thead>
            <tr><td><?= Admin::t('layout_debug_luya_version'); ?>:</td><td><?= \luya\Boot::VERSION; ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_id'); ?>:</td><td><?= Yii::$app->id ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_sitetitle'); ?>:</td><td><?= Yii::$app->siteTitle ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_remotetoken'); ?>:</td><td><?= $this->context->colorizeValue(Yii::$app->remoteToken, true); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_assetmanager_forcecopy'); ?>:</td><td><?= $this->context->colorizeValue(Yii::$app->assetManager->forceCopy); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_transfer_exceptions'); ?>:</td><td><?= $this->context->colorizeValue(Yii::$app->errorHandler->transferException); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_caching'); ?>:</td><td><?= (Yii::$app->has('cache')) ? Yii::$app->cache->className() : $this->context->colorizeValue(false); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_yii_debug'); ?>:</td><td><?= $this->context->colorizeValue(YII_DEBUG); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_yii_env'); ?>:</td><td><?= YII_ENV; ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_yii_timezone'); ?>:</td><td><?= Yii::$app->timeZone; ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_php_timezone'); ?>:</td><td><?= date_default_timezone_get(); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_php_ini_memory_limit'); ?>:</td><td><?= ini_get('memory_limit'); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_php_ini_max_exec'); ?>:</td><td><?= ini_get('max_execution_time'); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_php_ini_post_max_size'); ?>:</td><td><?= ini_get('post_max_size'); ?></td></tr>
            <tr><td><?= Admin::t('layout_debug_php_ini_upload_max_file'); ?>:</td><td><?= ini_get('upload_max_filesize'); ?></td></tr>
        </table>
    </div>

    <div ng-if="showOnlineContainer" class="useronline__modal">
        <table>
            <thead>
            <tr>
                <th></th>
                <th><?= Admin::t('layout_useronline_name'); ?></th>
                <th><?= Admin::t('layout_useronline_mail'); ?></th>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="row in notify" ng-class="{ 'green lighten-3' : row.is_active, 'red lighten-3' : !row.is_active }">
                <td>
                    <i ng-show="row.is_active" class="material-icons">tag_faces</i>
                    <i ng-show="!row.is_active" class="material-icons">help_outline</i>
                </td>
                <td>{{row.firstname}} {{row.lastname}}</td>
                <td>{{row.email}}</td>
                <td>
                    <small ng-hide="row.is_active">
                        <span><?= Admin::t('layout_useronline_inactivesince'); ?>: <b>{{row.inactive_since}}</b></span>
                        <br /><small>{{ row.lock_description }}</small>
                    </small>
                    <small ng-show="row.is_active">{{ row.lock_description }}</small>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div ng-class="{ 'search-box--open' : searchInputOpen }" class="search-box" zaa-esc="escapeSearchInput()">

        <div class="center" ng-show="searchResponse==null && searchQuery.length <= 2 && searchQuery.length > 0">
            <br /><br /><br />
            <p><?= Admin::t('layout_search_min_letters'); ?></p>
        </div>

        <div class="center" ng-show="(searchResponse.length == 0 && searchResponse != null) && searchQuery.length > 2">
            <br /><br /><br />
            <p><?= Admin::t('layout_search_no_results'); ?></p>
        </div>

        <div class="center" ng-show="searchResponse==null && searchQuery.length > 2">
            <br /><br /><br />
            <div class="preloader-wrapper small active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" ng-repeat="item in searchResponse">
            <div class="col s12">
                <b class="search-box__group-title"><i class="left material-icons">{{item.menuItem.icon}}</i> {{item.menuItem.alias}}</b>
				<table class="search-box__table">
                    <thead>
                        <tr ng-repeat="row in item.data | limitTo:1">
                            <th ng-hide="!item.hideFields.indexOf(k)" ng-repeat="(k,v) in row">{{k}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="row in item.data" ng-click="searchDetailClick(item, row)">
                            <td class="search-box__row" ng-hide="!item.hideFields.indexOf(k)" ng-repeat="(k,v) in row">{{v}}</td>
                        </tr>
                    </tbody>
                </table>
                <br /><br />
            </div>
        </div>
    </div>

    <!-- ANGULAR-VIEW -->
    <div class="luya-container__angular-placeholder module-{{currentItem.moduleId}}" ui-view></div>
    <!-- /ANGULAR-VIEW -->
    <div class="luya-container__right-panel" ng-if="sidePanelHelp">
        <div ng-if="sidePanelHelp">
            <h4><?= Admin::t('right_panel_support_title'); ?></h4>
            <ul class="collapsible" data-collapsible="accordion" ng-init="tagsOpen=false">
                <li>
                  <div class="collapsible-header" ng-click="tagsOpen=!tagsOpen"><i class="material-icons">filter_drama</i><?= Admin::t('right_panel_support_tags_title'); ?></div>
                  <div class="collapsible-body" ng-show="tagsOpen" style="display:block;">
                    <ul class="collection with-header">
                    <?php foreach ($this->context->tags as $name => $object): ?>
                        <li class="collection-item" click-paste-pusher="<?= $object->example(); ?>" style="cursor: pointer;" ng-mouseenter="isHover['<?=$name;?>']=true" ng-mouseleave="isHover['<?=$name;?>']=false">
                            <div class="help-overlay" ng-show="isHover['<?=$name;?>']">
                                <h3 class="help-overlay__title"><?= $name; ?></h3>
                                <code class="help-overlay__example-code"><?= $object->example(); ?></code>
                                <div class="help-overlay__description"><?= Markdown::process($object->readme()); ?></div>
                            </div>
                            <div><?= $name; ?><a class="secondary-content"><i class="material-icons">content_paste</i></a></div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header" ng-click="supportOpen=!supportOpen"><i class="material-icons">whatshot</i><?= Admin::t('right_panel_support_support_title'); ?></div>
                  <div class="collapsible-body" ng-show="supportOpen" style="display:block;"><p><?= Admin::t('right_panel_support_support_text'); ?></p></div>
                </li>
             </ul>
        </div>
    </div>
</div> <!-- /.luya-container -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>