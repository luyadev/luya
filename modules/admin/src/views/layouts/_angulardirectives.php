<?php
use luya\admin\Module as Admin;
?>
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
<div class="modal fade" tabindex="-1" aria-hidden="true" ng-class="{'show':!isModalHidden}" ng-style="{display: (isModalHidden ? 'none' : 'block')}" zaa-esc="isModalHidden=1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" ng-transclude />
    </div>
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
<div class="filemanager"  ng-paste="pasteUpload($event)">

    <div class="row">

        <!-- Folders -->
        <div class="col filemanager-folders">

            <div class="btn btn-block text-left btn-success">
                <span class="material-icons">add_box</span>
                <span class="btn-icon-label">Create new folder</span>
            </div>

            <ul class="folders mt-4">

                <li class="folders-item">
                    <span class="folders-collapse">
                        <i class="material-icons">keyboard_arrow_down</i>
                    </span>

                    <span class="folders-text folders-label">
                        <span class="folders-folder-icon folders-folder-icon-open">
                            <i class="material-icons">folder_open</i>
                        </span>
                        <span class="folders-folder-icon">
                            <i class="material-icons">folder</i>
                        </span>

                        Images
                    </span>
                    <span class="folders-text folders-input">
                        <input class="form-control" type="text" value="Images" id="change-folder-name" />
                    </span>
                    <span class="folders-text folders-confirm-delete-message">
                        Delete forever?
                    </span>

                    <span class="folders-actions">

                        <span class="folders-actions-default">
                            <span class="folders-action-edit">
                                <i class="material-icons">mode_edit</i>
                            </span>

                            <span class="folders-action-delete">
                                <i class="material-icons">delete_forever</i>
                            </span>
                        </span>

                        <span class="folders-actions-confirm">
                            <span class="folders-action-save">
                                <i class="material-icons">check</i>
                            </span>

                            <span class="folders-action-abort">
                                <i class="material-icons">clear</i>
                            </span>
                        </span>

                    </span>

                    <ul class="folders">

                        <li class="folders-item is-active">
                            <span class="folders-collapse"></span>

                            <span class="folders-text folders-label">
                                <span class="folders-folder-icon folders-folder-icon-open">
                                    <i class="material-icons">folder_open</i>
                                </span>
                                <span class="folders-folder-icon">
                                    <i class="material-icons">folder</i>
                                </span>

                                Images
                            </span>
                            <span class="folders-text folders-input">
                                <input class="form-control" type="text" value="Images" id="change-folder-name" />
                            </span>
                            <span class="folders-text folders-confirm-delete-message">
                                Delete forever?
                            </span>

                            <span class="folders-actions">

                                <span class="folders-actions-default">
                                    <span class="folders-action-edit">
                                        <i class="material-icons">mode_edit</i>
                                    </span>

                                    <span class="folders-action-delete">
                                        <i class="material-icons">delete_forever</i>
                                    </span>
                                </span>

                                <span class="folders-actions-confirm">
                                    <span class="folders-action-save">
                                        <i class="material-icons">check</i>
                                    </span>

                                    <span class="folders-action-abort">
                                        <i class="material-icons">clear</i>
                                    </span>
                                </span>

                            </span>

                        </li>

                        <li class="folders-item">
                            <span class="folders-collapse">
                                <i class="material-icons">keyboard_arrow_down</i>
                            </span>

                            <span class="folders-text folders-label">
                                <span class="folders-folder-icon folders-folder-icon-open">
                                    <i class="material-icons">folder_open</i>
                                </span>
                                <span class="folders-folder-icon">
                                    <i class="material-icons">folder</i>
                                </span>

                                Images
                            </span>
                            <span class="folders-text folders-input">
                                <input class="form-control" type="text" value="Images" id="change-folder-name" />
                            </span>
                            <span class="folders-text folders-confirm-delete-message">
                                Delete forever?
                            </span>

                            <span class="folders-actions">

                                <span class="folders-actions-default">
                                    <span class="folders-action-edit">
                                        <i class="material-icons">mode_edit</i>
                                    </span>

                                    <span class="folders-action-delete">
                                        <i class="material-icons">delete_forever</i>
                                    </span>
                                </span>

                                <span class="folders-actions-confirm">
                                    <span class="folders-action-save">
                                        <i class="material-icons">check</i>
                                    </span>

                                    <span class="folders-action-abort">
                                        <i class="material-icons">clear</i>
                                    </span>
                                </span>

                            </span>

                            <ul class="folders">

                                <li class="folders-item">
                                    <span class="folders-collapse"></span>

                                    <span class="folders-text folders-label">
                                        <span class="folders-folder-icon folders-folder-icon-open">
                                            <i class="material-icons">folder_open</i>
                                        </span>
                                        <span class="folders-folder-icon">
                                            <i class="material-icons">folder</i>
                                        </span>

                                        Images
                                    </span>
                                    <span class="folders-text folders-input">
                                        <input class="form-control" type="text" value="Images" id="change-folder-name" />
                                    </span>
                                    <span class="folders-text folders-confirm-delete-message">
                                        Delete forever?
                                    </span>

                                    <span class="folders-actions">

                                        <span class="folders-actions-default">
                                            <span class="folders-action-edit">
                                                <i class="material-icons">mode_edit</i>
                                            </span>

                                            <span class="folders-action-delete">
                                                <i class="material-icons">delete_forever</i>
                                            </span>
                                        </span>

                                        <span class="folders-actions-confirm">
                                            <span class="folders-action-save">
                                                <i class="material-icons">check</i>
                                            </span>

                                            <span class="folders-action-abort">
                                                <i class="material-icons">clear</i>
                                            </span>
                                        </span>

                                    </span>

                                </li>

                                <li class="folders-item">
                                    <span class="folders-collapse"></span>

                                    <span class="folders-text folders-label">
                                        <span class="folders-folder-icon folders-folder-icon-open">
                                            <i class="material-icons">folder_open</i>
                                        </span>
                                        <span class="folders-folder-icon">
                                            <i class="material-icons">folder</i>
                                        </span>

                                        Images
                                    </span>
                                    <span class="folders-text folders-input">
                                        <input class="form-control" type="text" value="Images" id="change-folder-name" />
                                    </span>
                                    <span class="folders-text folders-confirm-delete-message">
                                        Delete forever?
                                    </span>

                                    <span class="folders-actions">

                                        <span class="folders-actions-default">
                                            <span class="folders-action-edit">
                                                <i class="material-icons">mode_edit</i>
                                            </span>

                                            <span class="folders-action-delete">
                                                <i class="material-icons">delete_forever</i>
                                            </span>
                                        </span>

                                        <span class="folders-actions-confirm">
                                            <span class="folders-action-save">
                                                <i class="material-icons">check</i>
                                            </span>

                                            <span class="folders-action-abort">
                                                <i class="material-icons">clear</i>
                                            </span>
                                        </span>

                                    </span>

                                </li>

                            </ul>

                        </li>

                    </ul>

                </li>

                <li class="folders-item edit">
                    <span class="folders-collapse">
                    </span>

                    <span class="folders-text folders-label">
                        <span class="folders-folder-icon folders-folder-icon-open">
                            <i class="material-icons">folder_open</i>
                        </span>
                        <span class="folders-folder-icon">
                            <i class="material-icons">folder</i>
                        </span>

                        Edit mode
                    </span>
                    <span class="folders-text folders-input">
                        <input class="form-control" type="text" value="Edit mode" id="change-folder-name" />
                    </span>
                    <span class="folders-text folders-confirm-delete-message">
                        Delete forever?
                    </span>

                    <span class="folders-actions">

                        <span class="folders-actions-default">
                            <span class="folders-action-edit">
                                <i class="material-icons">mode_edit</i>
                            </span>

                            <span class="folders-action-delete">
                                <i class="material-icons">delete_forever</i>
                            </span>
                        </span>

                        <span class="folders-actions-confirm">
                            <span class="folders-action-save">
                                <i class="material-icons">check</i>
                            </span>

                            <span class="folders-action-abort">
                                <i class="material-icons">clear</i>
                            </span>
                        </span>

                    </span>

                </li>

                <li class="folders-item delete">
                    <span class="folders-collapse"></span>

                    <span class="folders-text folders-label">
                        <span class="folders-folder-icon folders-folder-icon-open">
                            <i class="material-icons">folder_open</i>
                        </span>
                        <span class="folders-folder-icon">
                            <i class="material-icons">folder</i>
                        </span>

                        Edit mode
                    </span>
                    <span class="folders-text folders-input">
                        <input class="form-control" type="text" value="Edit mode" id="change-folder-name" />
                    </span>
                    <span class="folders-text folders-confirm-delete-message">
                        Delete forever?
                    </span>

                    <span class="folders-actions">

                        <span class="folders-actions-default">
                            <span class="folders-action-edit">
                                <i class="material-icons">mode_edit</i>
                            </span>

                            <span class="folders-action-delete">
                                <i class="material-icons">delete_forever</i>
                            </span>
                        </span>

                        <span class="folders-actions-confirm">
                            <span class="folders-action-save">
                                <i class="material-icons">check</i>
                            </span>

                            <span class="folders-action-abort">
                                <i class="material-icons">clear</i>
                            </span>
                        </span>

                    </span>

                </li>

            </ul>

        </div>
        <!-- /Folders -->

        <!-- Files -->
        <div class="col filemanager-files">

            <div class="row">

                <div class="col">

                    <div class="filemanager-file-actions">

                        <div class="filemanager-file-actions-left">

                            <div class="btn btn-success">
                                <span class="material-icons">add_box</span>
                                <span class="btn-icon-label">Add file</span>
                            </div>

                        </div>

                        <div class="filemanager-file-actions-right">

                            <div class="btn btn-info">
                                <span class="material-icons">subdirectory_arrow_right</span>
                                <span class="btn-icon-label">Move X files</span>
                            </div>

                            <div class="btn btn-danger">
                                <span class="material-icons">delete_forever</span>
                                <span class="btn-icon-label">Delete X files</span>
                            </div>

                        </div>

                    </div>

                    <table class="table table-hover table-striped table-align-middle mt-4">
                        <thead class="thead-default">
                            <tr>
                                <th>
                                    <span>
                                        <i class="material-icons">done_all</i>
                                    </span>
                                </th>
                                <th></th>
                                <th>
                                    <span>Name</span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th>
                                    <span>Type</span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th>
                                    <span>Creation Date</span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th>
                                    <span>File size</span>
                                    <div class="table-sorter table-sorter-up">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </div>
                                    <div class="table-sorter table-sorter-down">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </div>
                                </th>
                                <th class="tab-padding-right text-right">
                                    <span class="crud-counter">9 files</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
							<tr 
                   				 ng-repeat="file in filesData | filemanagerfilesfilter:currentFolderId:onlyImages:searchQuery | filter:searchQuery | orderBy:sortField" 
                   				 alt="fileId={{file.id}}" 
                    			title="fileId={{file.id}}" 
                    			class="filemanager__file" 
                    			ng-class="{ 'clickable selectable' : allowSelection == 'false', 'filemanager__file--selected': selectedFileFromParent && selectedFileFromParent.id == file.id}">

					<th scope="row" ng-hide="allowSelection == 'true' ng-click="toggleSelection(file)">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" ng-checked="inSelection(file)" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </th>
                    <td ng-if="selectedFileFromParent">
                       <span class="custom-control-indicator"></span>
                    </td>
                    <td ng-click="toggleSelection(file)" class="text-center">
                        <span ng-if="file.isImage"><img class="responsive-img filmanager__thumb" ng-src="{{file.thumbnail.source}}" /></span>
                        <span ng-if="!file.isImage"><i class="material-icons">attach_file</i></span>
                    </td>
                    <td ng-click="toggleSelection(file)">{{file.name}}</td>
                    <td>{{file.extension}}</td>
                    <td>{{file.uploadTimestamp * 1000 | date:"short"}}</td>
                    <td>{{file.sizeReadable}}</td>
                    <td>
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
                                        <span class="flag__fallback">EN</span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroup">

                                    <span class="flag flag--de">
                                        <span class="flag__fallback">DE</span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroup">

                                    <span class="flag flag--fr">
                                        <span class="flag__fallback">FR</span>
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
