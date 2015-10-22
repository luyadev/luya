<?php
use \admin\Module;
use \yii\helpers\Url;

$user = Yii::$app->adminuser->getIdentity();

$this->beginPage()
?><!DOCTYPE html>
<html ng-app="zaa" ng-controller="LayoutMenuController">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= Yii::$app->siteTitle; ?> // {{currentItem.alias}}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?= Url::base(true); ?>/admin" />
        <style type="text/css">
        [ng:cloak],
        [ng-cloak],
        [data-ng-cloak],
        [x-ng-cloak],
        .ng-cloak,
        .x-ng-cloak {
          display: none !important;
        }
        </style>
        <?php $this->head() ?>
        <script>
            var authToken = '<?=$user->getAuthToken();?>';
        </script>
    </head>

    <body ng-cloak>
        <?php $this->beginBody() ?>
        <!-- ANGULAR SCRIPTS -->

        <script type="text/ng-template" id="modal">
            <div class="modal" ng-show="!isModalHidden" style="z-index:999999">
                <span class="modal__close btn-floating red" ng-show="!isModalHidden" ng-click="isModalHidden = true">
                    <i class="mdi-navigation-close"></i>
                </span>
                <div class="modal-content" ng-transclude></div>
            </div>
        </script>

        <script type="text/ng-template" id="storageFileUpload">
            <div class="fileupload">
                <div class="fileupload__btn btn-flat [ grey lighten-4 ]" ng-click="toggleModal()">
                    <i class="mdi-editor-attach-file left"></i>
                    <span>
                        Datei auswählen
                    </span>
                </div>
                <input class="fileupload__path" type="text" ng-model="fileinfo.source_http" disabled placeholder="<- Wählen Sie eine Datei aus. Der Pfad wird hier dargestellt." />

                <modal is-modal-hidden="modal"><storage-file-manager selection="true" /></modal>
            </div>
        </script>

        <script type="text/ng-template" id="storageImageUpload">
            <div class="imageupload">
                <storage-file-upload ng-model="fileId"></storage-file-upload>

                <div ng-show="originalFileIsRemoved">
                    <div class="alert alert--danger">Die Originale Datei wurde entfernt. Sie können keine Filter anwenden ohne original Datei. Laden Sie eine neue Datei hoch und Filter anzuwenden.</div>
                </div>
                <div class="imageupload__filter" ng-show="!originalFileIsRemoved && !noFilters()">
                    <label>Filter Auswahl</label>
                    <select name="filterId" ng-model="filterId" class="browser-default"><option value="0">Kein Filter</option><option ng-repeat="item in filters" value="{{ item.id }}">{{ item.name }} ({{ item.identifier }})</option></select>
                </div><!--
                --><div class="imageupload__preview">
                    <img ng-src="{{imageinfo.source}}" class="responsive-img" />
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
            </div>
        </script>

        <script type="text/ng-template" id="reverseFolders">
                    <div class="filemanager__folder-button">
                        <i class="mdi-file-folder-open filemanager__folder-icon filemanager__folder-icon--default"></i>
                        <i class="mdi-file-folder filemanager__folder-icon filemanager__folder-icon--active"></i>
                        <i class="mdi-editor-mode-edit filemanager__edit-icon" ng-click="folder.edit=!folder.edit"></i>
                        <i class="mdi-content-add filemanager__delete-icon" ng-click="folder.remove=!folder.remove"></i>
                        <span ng-show="!folder.edit"><span ng-click="loadFolder(folder.data.id)">{{folder.data.name }}</span>
                            <button ng-click="moveFilesTo(folder.data)" ng-show="showFoldersToMove && currentFolderId != folder.data.id" type="button">{{selectedFiles.length}} Dateien verschieben</button>
                        </span>
                        <span ng-show="folder.edit"><input type="text" ng-model="folder.data.name" /><button type="button" ng-click="updateFolder(folder)">Speichern</button></span>
                        <span ng-show="folder.remove"><button type="button" ng-click="deleteFolder(folder)">Löschen</button></span>

                        <!-- mdi-mdi-action-highlight-remove -->
                    </div>
                    <ul class="filemanager__folders" ng-if="folder.__items.length > 0">
                        <li class="filemanager__folder"  ng-class="{'active' : currentFolderId == folder.data.id }" ng-repeat="folder in folder.__items"  ng-include="'reverseFolders'"></li>
                    </ul>
        </script>
        
        <!-- FILEMANAGER -->
        <script type="text/ng-template" id="storageFileManager">

            <div class="filemanager">

                <!-- TREE -->
                <div class="filemanager__tree">

                    <div class="filemanager__toolbar">
                        
                        <div class="floating-form left" ng-class="{ 'floating-form--active' : showFolderForm }">
                            <div class="floating-form__form">
                                <input class="floating-form__input" type="text" ng-model="newFolderName" id="foldername" />
                            </div><!-- PREVENT WHITESPACE
                         --><div class="floating-form__actions">
                                <span class="[ floating-form__button floating-form__button--active ] btn-floating" ng-click="createNewFolder(newFolderName)"><i class="mdi-navigation-check"></i></span>
                                <span class="floating-form__button floating-form__button--active-close btn-floating" ng-click="folderFormToggler()"><i class="mdi-content-add"></i></span>
                            </div><!-- PREVENT WHITESPACE
                         --><span class="floating-form__label" ng-click="folderFormToggler()">Ordner hinzufügen</span>
                        </div>

                    </div>

                    <!-- FOLDER LIST -->
                    <ul class="filemanager__folders">
                        <li class="filemanager__folder" ng-class="{'active' : currentFolderId == 0 }">
                            <div class="filemanager__folder-button" ng-click="loadFolder(0)">
                                <i class="mdi-file-folder-open filemanager__folder-icon filemanager__folder-icon--default"></i>
                                <i class="mdi-file-folder filemanager__folder-icon filemanager__folder-icon--active"></i>
                                <span>Stammverzeichnis</span>
                            </div>
                            <ul class="filemanager__folders" ng-if="folders.length > 0">
                                <li class="filemanager__folder" ng-class="{'active' : currentFolderId == folder.data.id }" ng-repeat="folder in folders" ng-include="'reverseFolders'"></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- /FOLDER LIST -->

                </div><!--
                /TREE

                FILES & FOLDERS
             --><div class="filemanager__files">

                    <div class="filemanager__toolbar">
                        
                        <label class="floating-button-label left" ngf-select ngf-multiple="true" ng-model="uploadingfiles">
                            <span class="btn-floating">
                                <i class="mdi-file-file-upload"></i>
                            </span>
                            <span class="floating-button-label__label">Datei hinzufügen</span>
                        </label>

                        <div class="alert alert--danger" ng-show="errorMsg" style="clear:both;">Fehler beim Hochladen der Datei: {{errorMsg}}</div>
 
                        <div class="modal modal--bottom-sheet" ng-class="{ 'modal--active' : uploading && !serverProcessing }">

                            <div class="row">
                                <div class="col s12">
                                    <ul class="collection">
                                        <li class="collection-item file" ng-repeat="file in uploadingfiles" ng-class="{ 'file--completed' : file.processed }">
                                            <b>{{file.name}}</b>
                                            <div class="file__progress progress">
                                                <div class="determinate" style="width: {{file.progress}}%"></div>
                                            </div>
                                            <i class="file__icon mdi-navigation-check"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="filemanager__upload-overlay" ng-show="uploading || serverProcessing">
                            <div class="filemanager__upload-content">
                                <h3 class="filemanager__upload-title" ng-show="serverProcessing">
                                    Der Server verarbeitet Ihre Daten. <br />
                                    Bitte warten Sie einen Augenblick.
                                </h3>

                                <div class="filemanager__upload-loader preloader-wrapper big active" ng-show="serverProcessing">
                                    <div class="spinner-layer spinner-blue">
                                    <div class="circle-clipper left">
                                      <div class="circle"></div>
                                    </div><div class="gap-patch">
                                      <div class="circle"></div>
                                    </div><div class="circle-clipper right">
                                      <div class="circle"></div>
                                    </div>
                                    </div>

                                    <div class="spinner-layer spinner-red">
                                    <div class="circle-clipper left">
                                      <div class="circle"></div>
                                    </div><div class="gap-patch">
                                      <div class="circle"></div>
                                    </div><div class="circle-clipper right">
                                      <div class="circle"></div>
                                    </div>
                                    </div>

                                    <div class="spinner-layer spinner-yellow">
                                    <div class="circle-clipper left">
                                      <div class="circle"></div>
                                    </div><div class="gap-patch">
                                      <div class="circle"></div>
                                    </div><div class="circle-clipper right">
                                      <div class="circle"></div>
                                    </div>
                                    </div>

                                    <div class="spinner-layer spinner-green">
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

                    </div>

                    <button ng-show="selectedFiles.length > 0" ng-click="removeSelectedItems()"><b>{{selectedFiles.length}}</b> markierte Dateien löschen</button>
                    <button ng-show="selectedFiles.length > 0" ng-click="showFoldersToMove=!showFoldersToMove">Verschieben nach</button>

                    <table class="filemanager__table striped hoverable">
                        <thead>
                            <tr>
                                <th class="filemanager__checkox-column" ng-hide="allowSelection == 'true'">
                                    <i class="mdi-action-done-all clickable" ng-click="toggleSelectionAll()"></i>
                                </th>
                                <th></th>
                                <th>Name</th>
                                <th>Typ</th>
                                <th>Eigentümer</th>
                                <th>Erstellungsdatum</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- FILES -->
                            <tr ng-repeat="file in files" ng-hide="verifyFileHidden(file)" ng-click="toggleSelection(file)" class="filemanager__file" ng-class="{ 'clickable selectable' : allowSelection == 'false' }">
                                <td class="filemanager__checkox-column"  ng-hide="allowSelection == 'true'">
                                    <input type="checkbox" id="{{file.id}}" ng-checked="inSelection(file)" />
                                    <label for="checked-status-managed-by-angular-{{file.id}}"></label>
                                </td>
                                <td class="filemanager__icon-column" ng-class="{ 'filemanager__icon-column--thumb' : file.thumbnail }">
                                        <span ng-if="file.thumbnail">
                                            <img class="responsive-img" ng-src="{{file.thumbnail.source}}" />
                                        </span>
                                        <span ng-if="!file.thumbnail">
                                            <i class="mdi-editor-attach-file"></i>
                                        </span>
                                </td>
                                <td>{{file.name_original}}</td>
                                <td class="filemanager__lighten">{{file.extension}}</td>
                                <td class="filemanager__lighten">{{file.firstname}} {{file.lastname}}</td>
                                <td class="filemanager__lighten">{{file.upload_timestamp * 1000 | date:"dd.MM.yyyy, HH:mm"}} Uhr</td>
                            </tr>
                            <!-- /FILES -->

                        </tbody>
                    </table>

                    <button ng-show="selectedFiles.length > 0" ng-click="removeSelectedItems()"><b>{{selectedFiles.length}}</b> markierte Dateien löschen</button>
                    <button ng-show="selectedFiles.length > 0" ng-click="showFoldersToMove=!showFoldersToMove">Verschieben nach</button>

                </div>
                <!-- FILES & FOLDERS -->

            </div>

        </script>
        <!-- /FILEMANAGER -->

        <!-- /ANGULAR SCRIPTS -->

        <div class="luya-container ng-cloak">

            <div class="navbar-fixed">
                <nav>
                    <div class="nav-wrapper blue">

                        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>

                        <ul class="left hide-on-med-and-down">
                            <li ng-repeat="item in items" ng-class="{'active' : isActive(item) }">
                                <a ng-click="click(item)" class="navbar__link"><i class="[ {{item.icon}} left ] navbar__icon"></i>{{item.alias}}</a>
                            </li>
                        </ul>

                        <ul class="right navbar__right">
                            <li ng-click="reload()" style="cursor: pointer;"><i class="mdi-av-replay"></i></li>
                            <li ng-mouseenter="showDebugContainer=1" ng-mouseleave="showDebugContainer=0">
                                <i class="mdi-notification-sms-failed" style="text-align:center; margin: 0 15px;"></i>
                                
                            </li>
                            <li ng-mouseenter="showOnlineContainer=1" ng-mouseleave="showOnlineContainer=0">
                                <div class="navbar__button">
                                    <i class="[ mdi-social-group left ] navbar__icon"></i>
                                    {{notify.length}}
                                </div>
                            </li>
                            <li>
                                <div class="user-menu" ng-mouseenter="userMenuOpen = true" ng-mouseleave="userMenuOpen = false" ng-class="{ 'user-menu--show-user' : !userMenuOpen, 'user-menu--show-menu' : userMenuOpen }">

                                    <div class="user-menu__user">
                                        <i class="mdi-action-account-circle left"></i><strong><?php echo $user->firstname; ?></strong>
                                    </div>

                                    <div class="user-menu__menu">
                                        <i class="mdi-action-settings user-menu__menu-icon"></i><!-- NO WHITESPACE
                                        --><a href="<?= \Yii::$app->urlManager->createUrl(['admin/default/logout']); ?>" class="user-menu__menu-icon user-menu__menu-icon--logout">
                                            <i class="mdi-action-exit-to-app"></i>
                                        </a>
                                    </div>

                                </div>
                            </li>
                        </ul>

                        <ul class="side-nav" id="mobile-demo">
                            <li ng-repeat="item in items" ng-class="{'active' : isActive(item) }">
                                <a ng-click="click(item)" class="navbar__link"><i class="[ {{item.icon}} left ] navbar__icon"></i>{{item.alias}}</a>
                            </li>
                        </ul>

                        <div class="navbar__search-wrapper" ng-class="{ 'navbar__search-wrapper--wide' : searchInputOpen }">
                            <div class="input-field navbar__search" ng-class="{ 'navbar__search--open' : searchInputOpen }">
                                <input id="global-search-input" ng-model="searchQuery" type="search" class="navbar__search-input">
                                <label for="global-search-input" class="navbar__search-label" ng-click="openSearchInput()"><i class="mdi-action-search"></i></label>
                                <i class="mdi-navigation-close navbar__search-icon" ng-click="closeSearchInput()"></i>
                            </div>
                        </div>
                    </div>
                </nav>
            </div> <!-- /navbar-fixed -->

            <div ng-show="showDebugContainer" class="debug-container">
                <table class="bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Wert</th>
                        </tr>
                    </thead>
                    <tr><td>Luya Version</td><td><?= luya\Module::VERSION; ?></td></tr>
                    <tr><td>Id:</td><td><?= Yii::$app->id ?></td></tr>
                    <tr><td>Site Title:</td><td><?= Yii::$app->siteTitle ?></td></tr>
                    <tr><td>Remote Token:</td><td><?= var_dump(Yii::$app->remoteToken); ?></td></tr>
                    <tr><td>YII_DEBUG:</td><td><?= var_dump(YII_DEBUG); ?></td></tr>
                    <tr><td>YII_ENV:</td><td><?= YII_ENV; ?></td></tr>
                    <tr><td>Transfer Exceptions:</td><td><?= var_dump(Yii::$app->errorHandler->transferException); ?></td></tr>
                    <tr><td>Yii Timezone:</td><td><?= Yii::$app->timeZone; ?></td></tr>
                    <tr><td>PHP Timezone:</td><td><?= date_default_timezone_get(); ?></td></tr>
                </table>
            </div>
            
            <div ng-show="showOnlineContainer" class="useronline__modal">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>E-Mail</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="row in notify" ng-class="{ 'green lighten-3' : row.is_active, 'red lighten-3' : !row.is_active }">
                            <td>
                                <i ng-show="row.is_active" class="mdi-action-face-unlock small"></i>
                                <i ng-show="!row.is_active" class="mdi-maps-hotel small"></i>
                            </td>
                            <td>{{row.firstname}} {{row.lastname}}</td>
                            <td>{{row.email}}</td>
                            <td>
                                <small ng-hide="row.is_active">
                                    <b>Inaktiv seit</b><br />
                                    {{row.inactive_since}}
                                </small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div ng-class="{ 'search-box--open' : searchQuery }" class="search-box" zaa-esc="escapeSearchInput()">

                <div class="center" ng-show="searchResponse==null && searchQuery.length <= 2 && searchQuery.length > 0">
                    <br /><br /><br />
                    <p>Bitte geben Sie einen Suchbegriff mit mindestens <b>drei Buchstaben</b> ein.</p>
                </div>

                <div class="center" ng-show="(searchResponse.length == 0 && searchResponse != null) && searchQuery.length > 2">
                    <br /><br /><br />
                    <p>Es wurden keine Ergebnisse gefunden.</p>
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
                        <b class="search-box__group-title"><i class="left {{item.menuItem.icon}}"></i> {{item.menuItem.alias}}</b>

                        <table class="hoverable">
                            <thead>
                                <tr ng-repeat="row in item.data | limitTo:1">
                                    <th ng-repeat="(k,v) in row">{{k}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="row in item.data">
                                    <td ng-repeat="(k,v) in row">{{v}}</td>
                                    <td style="width: 20px;"><a href="" class="right"><i class="mdi-navigation-chevron-right"></i></a></td>
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

        </div> <!-- /.luya-container -->
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>