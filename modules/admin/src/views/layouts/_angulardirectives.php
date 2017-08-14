<?php
use luya\admin\Module as Admin;
?>
<div class="loading-overlay" ng-if="LuyaLoading.getState()">
    <div class="loading-overlay-content">
        <h3 class="loading-overlay-title">
            {{LuyaLoading.getStateMessage()}}
        </h3>

        <div class="loading-overlay-loader">
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
<div class="modal fade" tabindex="-1" aria-hidden="true" ng-class="{'show':!isModalHidden}" ng-style="{display: (isModalHidden ? 'none' : 'block')}" zaa-esc="isModalHidden=1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{title}}</h5>
                <button type="button" class="close" aria-label="Close" ng-click="isModalHidden=1">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body" ng-transclude />
    </div>
</div>
</script>

<!-- UPDATE REDIRECT FORM -->
<script type="text/ng-template" id="updateformredirect.html">
    <div class="row">
        <div class="form-group form-side-by-side">
            <div class="form-side form-side-label">
                <label><?= Admin::t('view_index_redirect_type'); ?></label>
            </div>
            <div class="form-side">
                <input type="radio" ng-model="data.type" ng-value="1" id="redirect_internal">
                <label for="redirect_internal" ng-click="data.type = 1"><?= Admin::t('view_index_redirect_internal'); ?></label>

                <input type="radio" ng-model="data.type" ng-value="2" id="redirect_external">
                <label for="redirect_external" ng-click="data.type = 2"><?= Admin::t('view_index_redirect_external'); ?></label>
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
                <label class="input-label"><?= Admin::t('view_index_redirect_external_link'); ?></label>
                <div class="input-field-wrapper">
                    <input name="text" type="text" class="input-field" ng-model="data.value" placeholder="http://" />
                    <small><?= Admin::t('view_index_redirect_external_link_help'); ?></small>
                </div>
            </div>
        </div>
    </div>
</script>
<!-- /UPDATE REDIRECT FORM -->

<script type="text/ng-template" id="menuDropdownReverse">
    <span class="treeview-label treeview-label-page" ng-click="changeModel(data)">
        <span class="treeview-icon">
            <input type="radio" ng-checked="data.id == navId" id="toggler-for-{{data.id}}" />
            <label for="toggler-for-{{data.id}}"></label>
        </span>
        <span class="treeview-link" >
            <span class="google-chrome-font-offset-fix">{{data.title}}</span>
        </span>
    </span>
    <ul class="treeview-items">
        <li class="treeview-item" ng-class="{'treeview-item-has-children' : (menuData.items | menuparentfilter:container.id:data.id).length}" ng-repeat="data in menuData.items | menuparentfilter:container.id:data.id" ng-include="'menuDropdownReverse'"></li>
    </ul>
</script>

<script type="text/ng-template" id="storageFileUpload">
    <div class="link-selector">
        <div class="link-selector-actions">
            <div class="link-selector-btn btn btn-secondary" ng-click="toggleModal()">
                <i class="material-icons left" ng-show="!fileinfo.name">file_upload</i>
                <i class="material-icons left" ng-show="fileinfo.name">attach_file</i>
                <span ng-if="fileinfo.name" ng-bind="fileinfo.name"></span>
                <span ng-if="!fileinfo.name">
                    <?= Admin::t('layout_select_file'); ?>
                </span>
            </div>
            <span class="link-selector-reset" ng-click="reset()" ng-show="fileinfo!=null">
                <i class="material-icons">remove_circle</i>
            </span>
        </div>
        <div ng-if="!modal.state">
            <modal is-modal-hidden="modal.state"><storage-file-manager selection="true" /></modal>
        </div>
    </div>
</script>

<script type="text/ng-template" id="storageImageUpload">
    <div class="imageupload">
        <div ng-if="imageNotFoundError" class="alert alert-danger" style="margin-top:0px;">The requested image id ({{ngModel}}) could not be found anymore. The orignal file has been deleted in the filemanager!</div>
        <div ng-show="originalFileIsRemoved">
            <div class="alert alert-danger"><?= Admin::t('layout_deleted_file'); ?></div>
        </div>
        <div class="imageupload-preview" ng-show="imageinfo != null">
            <div class="imageupload-preview-sizer"></div>
            <img ng-src="{{thumb.source}}" ng-show="imageinfo != null" class="imageupload-preview-image" />
            <div class="imageupload-infos">
                <div class="imageupload-size" ng-show="!imageLoading">{{ imageinfo.resolutionWidth }} x {{ imageinfo.resolutionHeight }}</div>
            </div>
        </div>
        <div class="imageupload-upload">
            <storage-file-upload ng-model="fileId"></storage-file-upload>
        </div>
        <div class="imageupload-filter" ng-show="!noFilters() && imageinfo != null">
            <select name="filterId" ng-model="filterId" convert-to-number><option value="0"><?= Admin::t('layout_no_filter'); ?></option><option ng-repeat="item in filtersData" value="{{ item.id }}">{{ item.name }} ({{ item.identifier }})</option></select>
        </div>

    </div>
</script>

<script type="text/ng-template" id="reverseFolders2">

    <i class="material-icons treeview-toggler filemanager-folder-toggleicon" ng-click="toggleFolderItem(folder)" ng-hide="folder.subfolder==0" ng-class="{'treeview-toggler--subnav-closed': folder.toggle_open!=1}">arrow_drop_down</i>
    <div class="filemanager-folder-button" ng-click="changeCurrentFolderId(folder.id)" tooltip tooltip-expression="folderCountMessage(folder)" tooltip-offset-top="-5">
        <i class="material-icons filemanager-folder-icon filemanager-folder-icon--default"></i>
        <i class="material-icons filemanager-folder-icon filemanager-folder-icon--active"></i>
                        <span class="filemanager-folder-name" ng-hide="folderUpdateForm && currentFolderId==folder.id">
                            {{folder.name }}                                            
                        </span>
                        <i class="material-icons filemanager-edit-icon" ng-click="toggleFolderMode('edit')">mode_edit</i>
                        <i class="material-icons filemanager-delete-icon" ng-click="toggleFolderMode('remove')">delete</i>

                        <span ng-if="folderUpdateForm && currentFolderId==folder.id">
                            <input type="text" ng-model="folder.name" class="filemanager-file-dialog-input"/>
                            <div class="filemanager-file-dialog">
                                <span><?= Admin::t('layout_filemanager_save_dir'); ?></span>
                                <div class="filemanager-file-dialog--buttons">
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager-file-dialog-icon" ng-click="updateFolder(folder)">check</i>
                                    </span>
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager-file-dialog-icon filemanager-cancel-icon" ng-click="toggleFolderMode(false)">add</i>
                                    </span>
                                </div>                                
                            </div>
                        </span>
                        <i class="material-icons filemanager-file-move-icon" ng-click="moveFilesTo(folder.id)" ng-show="showFoldersToMove && currentFolderId != folder.id">keyboard_return</i>
                        <span ng-if="folderDeleteForm && currentFolderId==folder.id">
                            <div class="filemanager-file-dialog">
                                <span><?= Admin::t('layout_filemanager_remove_dir'); ?></span>
                                <div class="filemanager-file-dialog--buttons">
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager-file-dialog-icon" ng-click="checkEmptyFolder(folder)">check</i>
                                    </span>
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager-file-dialog-icon filemanager-cancel-icon" ng-click="toggleFolderMode(false)">add</i>
                                    </span>
                                </div>
                            </div>
                        </span>

                        <span ng-if="folderDeleteConfirmForm && currentFolderId==folder.id">
                            <div class="filemanager-file-dialog">
                                <span><?= Admin::t('layout_filemanager_remove_dir_not_empty'); ?></span>
                                <div class="filemanager-file-dialog--buttons">
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager-file-dialog-icon" ng-click="deleteFolder(folder)">check</i>
                                    </span>
                                    <span class="btn-floating white">
                                        <i class="material-icons filemanager-file-dialog-icon filemanager-cancel-icon" ng-click="toggleFolderMode(false)">add</i>
                                    </span>
                                </div>
                            </div>
                        </span>

        <!-- mdi-mdi-action-highlight-remove -->
    </div>
    <ul class="filemanager-folders" ng-show="folder.toggle_open==1">
        <li class="filemanager-folder"  ng-class="{'filemanager-folder--active' : currentFolderId == folder.id, 'filemanager-folder--has-subfolders': folder.-items.length > 0}" ng-repeat="folder in foldersData | toArray:false | orderBy:'name' | filemanagerdirsfilter:folder.id"  ng-include="'reverseFolders'"></li>
    </ul>
</script>

<script type="text/ng-template" id="reverseFolders">
<span class="folders-text folders-label" tooltip tooltip-expression="folderCountMessage(folder)" tooltip-position="right" ng-click="changeCurrentFolderId(folder.id)" >
<span class="folders-folder-icon folders-folder-icon-open">
    <i class="material-icons">folder_open</i>
</span>
<span class="folders-folder-icon">
    <i class="material-icons">folder</i>
</span>
{{folder.name }}
</span>
<ul class="folders">
    <li class="folders-item" ng-class="{'is-active' : currentFolderId == folder.id}" ng-repeat="folder in foldersData | toArray:false | orderBy:'name' | filemanagerdirsfilter:folder.id" ng-include="'reverseFolders'"></li>
</ul>
</script>

<!-- FILEMANAGER -->
<script type="text/ng-template" id="storageFileManager">
<div class="filemanager"  ng-paste="pasteUpload($event)">
    <div class="row">
        <!-- Folders -->
        <div class="col filemanager-folders">
            <div class="btn btn-block text-left btn-success">
                <span class="material-icons">add</span>
                <span class="btn-icon-label"><?= Admin::t('layout_filemanager_add_folder'); ?></span>
            </div>
            <ul class="folders mt-4">
                <li class="folders-item" ng-class="{'is-active' : currentFolderId == 0}">
                    <span class="folders-text folders-label" ng-click="changeCurrentFolderId(0)">
                        <span class="folders-folder-icon folders-folder-icon-open">
                            <i class="material-icons">folder_open</i>
                        </span>
                        <span class="folders-folder-icon">
                            <i class="material-icons">folder</i>
                        </span>
                        <?= Admin::t('layout_filemanager_root_dir'); ?>
                    </span>
                    <ul class="folders">
                        <li class="folders-item" ng-class="{'is-active' : currentFolderId == folder.id}" ng-repeat="folder in foldersData | toArray:false | orderBy:'name' | filemanagerdirsfilter:0" ng-include="'reverseFolders'"></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /Folders -->
        <!-- Files -->
        <div class="col filemanager-files">

            <div class="row">

                <div class="col">

                    <div class="filemanager-file-actions">

                        <div class="filemanager-file-actions-left" ng-class="{'filemanager-file-actions-left-spacing': selectedFiles.length > 0}">

                            <div class="btn btn-success filemanager-upload-file"  ngf-enable-firefox-paste="true" ngf-drag-over-class="'dragover'" ngf-drop ngf-select ngf-multiple="true" ng-model="uploadingfiles">
                                <span class="material-icons">file_upload</span>
                                <span class="btn-icon-label"><?= Admin::t('layout_filemanager_upload_files'); ?></span>
                            </div>

                            <input class="filemanager-search" type="text"  ng-model="searchQuery" placeholder="<?= Admin::t('layout_filemanager_search_text') ?>" />

                        </div>

                        <div class="filemanager-file-actions-right" ng-show="selectedFiles.length > 0">

                            <div class="btn btn-info" ng-click="showFoldersToMove=!showFoldersToMove">
                                <span class="material-icons">subdirectory_arrow_right</span>
                                <span class="btn-icon-label"><?= Admin::t('layout_filemanager_move_selected_files'); ?></span>
                            </div>

                            <div class="btn btn-danger" ng-click="removeFiles()">
                                <span class="material-icons">delete_forever</span>
                                <span class="btn-icon-label"><b>{{selectedFiles.length}}</b> <?= Admin::t('layout_filemanager_remove_selected_files'); ?></span>
                            </div>

                        </div>
                    </div>
                    <table class="table table-hover table-striped table-align-middle mt-4">
                        <thead class="thead-default">
                            <tr>
                                <th ng-hide="allowSelection == 'true'">
                                    <span ng-click="toggleSelectionAll()">
                                        <i class="material-icons">done_all</i>
                                    </span>
                                </th>
                                <th ng-if="selectedFileFromParent" style="width:15px;"></th>
                                <th></th><!-- image thumbnail / file icon -->
                                <th>
                                    <span><?= Admin::t('layout_filemanager_col_name'); ?></span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th>
                                    <span><?= Admin::t('layout_filemanager_col_type'); ?></span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th>
                                    <span><?= Admin::t('layout_filemanager_col_date'); ?></span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th>
                                    <span><?= Admin::t('layout_filemanager_col_size'); ?></span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th class="tab-padding-right text-right">
                                    <span class="crud-counter">{{ (filesData | filemanagerfilesfilter:currentFolderId:onlyImages:searchQuery | filter:searchQuery).length }} files</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
							<tr
                   				ng-repeat="file in filesData | filemanagerfilesfilter:currentFolderId:onlyImages:searchQuery | filter:searchQuery | orderBy:sortField"
                   				alt="fileId={{file.id}}"
                    			title="fileId={{file.id}}"
                    			class="filemanager-file"
                    			ng-class="{ 'clickable selectable' : allowSelection == 'false', 'filemanager-file--selected': selectedFileFromParent && selectedFileFromParent.id == file.id}">

					<th scope="row" ng-hide="allowSelection == 'true'" ng-click="toggleSelection(file)">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-checked="inSelection(file)" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </th>

                    <td ng-if="selectedFileFromParent">
                       <span class="custom-control-indicator"></span>
                    </td>
                    <td ng-click="toggleSelection(file)" class="text-center">
                        <span ng-if="file.isImage"><img class="responsive-img filmanager-thumb" ng-src="{{file.thumbnail.source}}" /></span>
                        <span ng-if="!file.isImage"><i class="material-icons">attach_file</i></span>
                    </td>
                    <td ng-click="toggleSelection(file)">{{file.name}}</td>
                    <td>{{file.extension}}</td>
                    <td>{{file.uploadTimestamp * 1000 | date:"short"}}</td>
                    <td>{{file.sizeReadable}}</td>
                    <td class="text-right">
						<button type="button" class="btn btn-sm btn-link btn-icon" ng-click="openFileDetail(file)">
                                        <i class="material-icons">more_vert</i>
                                    </button></td>
		                </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col filemanager-detail-view" ng-class="{'open': fileDetail}">

                    <div class="file-detail-view">

                        <div class="file-detail-view-head">

                            <div class="btn btn-success">
                                <span class="material-icons">file_download</span>
                                <span class="btn-icon-label">Download</span>
                            </div>

                            <div class="btn btn-info ml-1">
                                <span class="material-icons">file_upload</span>
                                <span class="btn-icon-label">Replace</span>
                            </div>

                            <div class="file-detail-view-close">
                                <i class="material-icons">cancel</i>
                            </div>

                        </div>
                        <table class="table table-striped table-hover table-align-middle mt-4">
                            <tbody>
                                <tr>
                                    <th scope="row">Filename</th>
                                    <td>{{ fileDetail.name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Creation Date</th>
                                    <td>{{fileDetail.uploadTimestamp * 1000 | date:"dd.MM.yyyy, HH:mm"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">File Type</th>
                                    <td>{{ fileDetail.extension }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Size</th>
                                    <td>{{ fileDetail.sizeReadable }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Internal ID</th>
                                    <td>{{ fileDetail.id }}</td>
                                </tr>
                            </tbody>
                        </table>

						<div ng-if="fileDetail.isImage">
                    		<img class="img-fluid" ng-src="{{fileDetail.thumbnailMedium.source}}" />
                		</div>

                        <form class="bg-faded p-2 mt-4">
                            <h3 class="mb-3">File caption</h3>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroup">

                                    <span class="flag flag--en">
                                        <span class="flag-fallback">EN</span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroup">

                                    <span class="flag flag--de">
                                        <span class="flag-fallback">DE</span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroup">

                                    <span class="flag flag--fr">
                                        <span class="flag-fallback">FR</span>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Files -->
    </div>
</div>
</script>

<!-- FILEMANAGER -->
<script type="text/ng-template" id="storageFileManagerOld">

    <div class="filemanager" ng-paste="pasteUpload($event)">

        <!-- TREE -->
        <div class="filemanager-tree">

            <div class="filemanager-toolbar filemanager-toolbar--top">

                <div class="floating-form left" ng-class="{ 'floating-form--active' : showFolderForm }">
                    <div class="floating-form-form">
                        <input class="floating-form-input" type="text" ng-model="newFolderName" id="foldername" placeholder="<?= Admin::t('layout_filemanager_folder'); ?>" />
                    </div><!-- PREVENT WHITESPACE
                         --><div class="floating-form-actions">
                        <span class="[ floating-form-button floating-form-button--active ] btn-floating" ng-click="createNewFolder(newFolderName)"><i class="material-icons">check</i></span>
                        <span class="floating-form-button floating-form-button--active-close btn-floating" ng-click="folderFormToggler()"><i class="material-icons">add</i></span>
                    </div><!-- PREVENT WHITESPACE
                         --><span class="floating-form-label" ng-click="folderFormToggler()"><?= Admin::t('layout_filemanager_add_folder'); ?></span>
                </div>

            </div>

            <!-- FOLDER LIST -->
            <ul class="filemanager-folders">
                <li class="filemanager-folder filemanager-folder--root" ng-class="{'filemanager-folder--active' : currentFolderId == 0 }">
                    <div class="filemanager-folder-button folder-root" ng-click="changeCurrentFolderId(0)">
                        <i class="material-icons filemanager-folder-icon filemanager-folder-icon--root"></i>
                        <span class="filemanager-folder-name"><?= Admin::t('layout_filemanager_root_dir'); ?></span>
                    </div>
                    <ul class="filemanager-folders">
                        <li class="filemanager-folder" ng-class="{'filemanager-folder--active' : currentFolderId == folder.id}" ng-repeat="folder in foldersData | toArray:false | orderBy:'name' | filemanagerdirsfilter:0" ng-include="'reverseFolders'"></li>
                    </ul>
                </li>
            </ul>
            <!-- /FOLDER LIST -->

        </div><!--/TREE

                FILES & FOLDERS
             --><div class="filemanager-files">

            <div class="filemanager-toolbar filemanager-toolbar--top">

                <label class="floating-button-label left" ngf-enable-firefox-paste="true" ngf-drag-over-class="'dragover'" ngf-drop ngf-select ngf-multiple="true" ng-model="uploadingfiles">
                            <span class="btn-floating">
                                <i class="material-icons">file_upload</i>
                            </span>
                    <span class="floating-button-label-label"><?= Admin::t('layout_filemanager_upload_files'); ?></span>
                </label>

                <div class="filemanager-search input input--text">
                    <div class="input-field-wrapper">
                        <input class="input-field filemanager-search-input" type="text" ng-model="searchQuery" placeholder="<?= Admin::t('layout_filemanager_search_text') ?>" />
                    </div>
                </div>

                <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="removeFiles()"><b>{{selectedFiles.length}}</b> <?= Admin::t('layout_filemanager_remove_selected_files'); ?></button>
                <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="showFoldersToMove=!showFoldersToMove"><?= Admin::t('layout_filemanager_move_selected_files'); ?></button>

            </div>

            <div class="row">

            <div class="filemanager-col col" ng-class="{'filemanager-col--file-details' : fileDetail, 's12' : !fileDetail }">
            <table class="filemanager-table hoverable striped">
                <thead>
                    <tr>
                        <th class="filemanager-checkox-column" ng-hide="allowSelection == 'true'">
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
                    class="filemanager-file"
                    ng-class="{ 'clickable selectable' : allowSelection == 'false', 'filemanager-file--selected': selectedFileFromParent && selectedFileFromParent.id == file.id}">

                    <td ng-click="toggleSelection(file)" class="filemanager-checkox-column" ng-hide="allowSelection == 'true'">
                        <input type="checkbox" ng-checked="inSelection(file)" id="{{file.id}}" />
                        <label for="checked-status-managed-by-angular-{{file.id}}"></label>
                    </td>
                    <td ng-if="selectedFileFromParent">
                        <i class="material-icons" ng-if="selectedFileFromParent.id == file.id">check_box</i>
                    </td>
                    <td ng-click="toggleSelection(file)" class="filemanager-icon-column" ng-class="{ 'filemanager-icon-column--thumb' : file.isImage }">
                        <span ng-if="file.isImage"><img class="responsive-img filmanager-thumb" ng-src="{{file.thumbnail.source}}" /></span>
                        <span ng-if="!file.isImage"><i class="material-icons">attach_file</i></span>
                    </td>
                    <td ng-click="toggleSelection(file)">{{file.name}}</td>
                    <td class="filemanager-lighten">{{file.extension}}</td>
                    <td class="filemanager-lighten">{{file.uploadTimestamp * 1000 | date:"short"}}</td>
                    <td class="filemanager-ligthen">{{file.sizeReadable}}</td>
                    <td class="filemanager-lighten" ng-click="openFileDetail(file)"><i class="material-icons">zoom_in</i></td>
                </tr>
                <!-- /FILES -->

                </tbody>
            </table>
            </div>
            <div class="filemanager-details" ng-show="fileDetail">
                <div class="filemanager-details-bar">
                    <a ng-href="{{fileDetail.source}}" target="_blank" class="btn btn--small"><?= Admin::t('layout_filemanager_detail_download'); ?></a>
                    <button type="button" class="btn btn--small" type="file" ngf-keep="false" ngf-select="replaceFile($file, $invalidFiles)"><?= Admin::t('layout_filemanager_detail_replace_file'); ?></button>
                    <a class="filemanager-details-close btn red btn-floating right" ng-click="closeFileDetail()"><i class="material-icons">close</i></a>
                </div>

                <table class="filemanager-details-table filemanager-table">
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

                <div class="filemanager-details-panel clearfix">
                    <strong><?= Admin::t('layout_filemanager_file_captions'); ?></strong>
                    <div class="input input--text input--vertical" ng-repeat="(key, cap) in fileDetail.captionArray">
                        <span class="flag flag-{{key}}"><span class="flag-fallback flag-fallback-colorized">{{key}}</span></span>
                        <div class="input-field-wrapper">
                            <input class="input-field" id="id-{{key}}" name="{{key}}" type="text" ng-model="fileDetail.captionArray[key]" />
                        </div>
                    </div>
                    <button type="button" class="filemanager-detail-save-button btn btn--small right" ng-click="storeFileCaption(fileDetail)"><?= Admin::t('layout_filemanager_file_captions_save_btn'); ?></button>
                </div>
        </div>
        <!-- FILES & FOLDERS -->

        <div class="filemanager-toolbar filemanager-toolbar--bottom">

            <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="removeFiles()"><b>{{selectedFiles.length}}</b> <?= Admin::t('layout_filemanager_remove_selected_files'); ?></button>
            <button type="button" class="btn btn--small right" ng-show="selectedFiles.length > 0" ng-click="showFoldersToMove=!showFoldersToMove"><?= Admin::t('layout_filemanager_move_selected_files'); ?></button>

        </div>
    </div>

</script>
<!-- /FILEMANAGER -->
<!-- /ANGULAR SCRIPTS -->
