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
<div class="modal" tabindex="-1" aria-hidden="true" ng-class="{'show':!isModalHidden}" zaa-esc="isModalHidden=1">
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
                <span ng-if="fileinfo.name">{{fileinfo.name | truncateMiddle: 20}}</span>
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
    <span class="folders-actions" tooltip tooltip-expression="folderCountMessage(folder)" tooltip-position="right">
        <span class="folders-actions-left">
            <button class="folders-actions-toggler" ng-if="folder.subfolder == true"><i class="material-icons">keyboard_arrow_down</i></button>
        </span>

        <span class="folders-text folders-label" ng-click="changeCurrentFolderId(folder.id)">
            <span class="folders-folder-icon" ng-if="currentFolderId == folder.id">
                <i class="material-icons">folder_open</i>
            </span>
            <span class="folders-folder-icon" ng-if="currentFolderId != folder.id">
                <i class="material-icons">folder</i>
            </span>
            <span class="folders-folder-name" ng-hide="editFolderLabel">{{folder.name }}</span>
        </span>

        <span class="folder-text folder-edit" ng-show="editFolderLabel">
            <input class="folder-label-input" ng-model="folder.name" type="text" />
        </span>

        <span class="folders-actions-right" ng-class="{'folders-actions-right-edit': editFolderLabel }"  ng-show="!showFoldersToMove" ng-init="editFolderLabel = false">
            <button class="folders-actions-edit" ng-hide="editFolderLabel" ng-click="editFolderLabel=!editFolderLabel"><i class="material-icons">edit</i></button>
            <button class="folders-actions-delete" ng-hide="editFolderLabel"><i class="material-icons">delete</i></button>

            <button ng-show="editFolderLabel" class="folders-actions-save" ng-click="updateFolder(folder); editFolderLabel=!editFolderLabel"><i class="material-icons">check</i></button>
            <button ng-show="editFolderLabel" class="folders-actions-abort" ng-click="editFolderLabel=!editFolderLabel"><i class="material-icons">cancel</i></button>
        </span>

         <span class="folders-actions-right folders-actions-right-edit" ng-show="showFoldersToMove">
              <span class="folders-folder-move-icon" ng-click="moveFilesTo(folder.id)"><i class="material-icons">subdirectory_arrow_left</i></span>
         </span>
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


            <div class="filemanager-add-folder">

                <div class="btn btn-block text-left btn-success" ng-click="folderFormToggler()" ng-if="!showFolderForm">
                    <span class="material-icons">add</span>
                    <span class="btn-icon-label"><?= Admin::t('layout_filemanager_add_folder'); ?></span>
                </div>

                <div class="filemanager-add-folder-form" ng-if="showFolderForm">
                    <input class="filemanager-add-folder-input" type="text" placeholder="<?php echo Admin::t('layout_filemanager_folder'); ?>" title="<?php echo Admin::t('layout_filemanager_folder'); ?>" ng-model="newFolderName" />
                    <div class="filemanager-add-folder-actions">
                        <button class="btn btn-success" ng-click="createNewFolder(newFolderName)"><i class="material-icons">check</i></button>
                        <button class="btn btn-danger" ng-click="folderFormToggler()"><i class="material-icons">cancel</i></button>
                    </div>
                </div>

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
                                    <span class="filemanager-check-all" ng-click="toggleSelectionAll()">
                                        <i class="material-icons">done_all</i>
                                        <span class="filemanager-files-counter">({{ (filesData | filemanagerfilesfilter:currentFolderId:onlyImages:searchQuery | filter:searchQuery).length }} files)</span>
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
                                <th class="tab-padding-right text-right filemanager-actions-column"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                ng-repeat="file in filesData | filemanagerfilesfilter:currentFolderId:onlyImages:searchQuery | filter:searchQuery | orderBy:sortField" class="filemanager-file"
                                ng-class="{ 'clickable selectable' : allowSelection == 'false', 'filemanager-file-selected': selectedFileFromParent && selectedFileFromParent.id == file.id, 'filemanager-file-detail-open': fileDetail.id === file.id}"
                            >

                                <th scope="row" ng-click="toggleSelection(file)">
                                    <div class="filemanager-fakebox" ng-class="{'filemanager-fakebox-active': inSelection(file)}"></div>
                                </th>

                                <td class="text-center" ng-click="openFileDetail(file)" tooltip tooltip-image-url="{{file.thumbnailMedium.source}}" tooltip-disabled="!file.isImage">
                                    <span ng-if="file.isImage"><img class="responsive-img filmanager-thumb" ng-src="{{file.thumbnail.source}}" /></span>
                                    <span ng-if="!file.isImage"><i class="material-icons">attach_file</i></span>
                                </td>
                                <td ng-click="openFileDetail(file)">{{file.name | truncateMiddle: 30}}</td>
                                <td ng-click="openFileDetail(file)">{{file.extension}}</td>
                                <td ng-click="openFileDetail(file)">{{file.uploadTimestamp * 1000 | date:"short"}}</td>
                                <td ng-click="openFileDetail(file)">{{file.sizeReadable}}</td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-sm btn-icon" ng-click="openFileDetail(file)">
                                        <i class="material-icons">zoom_in</i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Files -->
    </div>
</div>

<div class="file-detail-view" ng-class="{'open': fileDetail}">

    <div class="file-detail-view-head">

        <a class="btn btn-success" ng-href="{{fileDetail.source}}" target="_blank">
            <span class="material-icons">file_download</span>
            <span class="btn-icon-label">Download</span>
        </a>

        <div class="btn btn-info ml-1" type="file" ngf-keep="false" ngf-select="replaceFile($file, $invalidFiles)">
            <span class="material-icons">file_upload</span>
            <span class="btn-icon-label">Replace</span>
        </div>

        <div class="file-detail-view-close" ng-click="closeFileDetail()">
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
        <div class="form-group" ng-repeat="(key, cap) in fileDetail.captionArray">
            <div class="input-group">
                <input type="text" class="form-control" ng-model="fileDetail.captionArray[key]">

                <span class="flag flag--{{key}}">
                                        <span class="flag-fallback">{{key}}</span>
                                    </span>
            </div>
        </div>

        <button type="button" class="btn btn-primary" ng-click="storeFileCaption(fileDetail)"><?= Admin::t('layout_filemanager_file_captions_save_btn'); ?></button>

    </form>

    <div class="file-detail-view-arrows">
        <div class="file-detail-view-arrow file-detail-view-arrow-prev disabled">
            <i class="material-icons">keyboard_arrow_up</i>
        </div>
        <div class="file-detail-view-arrow file-detail-view-arrow-next">
            <i class="material-icons">keyboard_arrow_down</i>
        </div>
    </div>

</div>

</script>

<!-- /ANGULAR SCRIPTS -->
