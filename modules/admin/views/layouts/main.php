<?php
    use \admin\Module;
    use \yii\helpers\Url;
    
    $user = Yii::$app->adminuser->getIdentity();
    
    $gravatar = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($user->email))).'?d='.urlencode('http://www.zephir.ch/files/rocky_460px_bw.jpg').'&s=40';

    $this->beginPage()
?>

<!DOCTYPE html>
<html ng-app="zaa" ng-controller="LayoutMenuController">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= \Yii::$app->siteTitle; ?> // {{currentItem.alias}}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?= Url::base(true); ?>/" 
        <?php $this->head() ?>

        <script>
            var authToken = '<?=$user->getAuthToken();?>';
        </script>
    </head>

    <body>
        <?php $this->beginBody() ?>
        <!-- 
        <script type="text/ng-template" id="storageFileUpload-bkp">
        <div class="row">
            <div class="input-field col s6">
                <input type="file" file-model="myFile" />
                <button ng-click="push()" type="button">Datei Hochladen</button>
            </div>
            <div class="input-field col s6">
                <button type="button" ng-click="openModal()">Show File manager</button>
                <modal is-modal-hidden="modal"><storage-file-manager ng-model="$parent.$parent.ngModel" selection="true" /></modal>
            </div>
        </div>
        </script>
         -->
        <!-- ANGULAR SCRIPTS -->

        <script type="text/ng-template" id="modal">
        <div class="modal" ng-show="!isModalHidden" style="z-index:999999">
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
                <input class="fileupload__path" type="text" ng-model="fileinfo.source_http" disabled />

                <modal is-modal-hidden="modal"><storage-file-manager selection="true" /></modal>
            </div>
        </script>
        
        <script type="text/ng-template" id="storageImageUpload">
            <div class="imageupload">
                <b class="imageupload__title">Bild und Filter festlegen</b>

                <storage-file-upload ng-model="fileId"></storage-file-upload>

                <div class="imageupload__filter">
                    <label>Filter Auswahl</label>
                    <select name="filterId" ng-model="filterId" class="browser-default"><option value="0">Kein Filter</option><option ng-repeat="item in filters" value="{{ item.id }}">{{ item.name }} ({{ item.identifier }})</option></select>
                </div>
                <div class="imageupload__preview">
                    <img src="{{imageinfo.source}}" class="responsive-img" />
                </div>
            </div>
        </script>

        <script type="text/ng-template" id="storageFileManager">

            <div class="row">
                <div class="col s11">

                    <ul class="breadcrumb">
                        <li class="breadcrumb__item" ng-repeat="crumb in breadcrumbs">
                            <i ng-hide="$first" class="breadcrumb__icon mdi-navigation-chevron-right"></i>
                            <button class="btn-flat breadcrumb__btn" ng-click="loadFolder(crumb.id)">{{crumb.name}}</button>
                        </li>
                    </ul>

                </div>
                <div class="col s1">
                    <button class="btn-floating red lighten-2 right" ng-click="toggleModal()"><i class="mdi-navigation-close small right" ng-show="allowSelection=='true'"></i></button>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <table class="striped">
                        <thead>
                            <tr>
                                <th class="filemanager__icon-column"></th>
                                <th>Name</th>
                                <th>Eigentümer</th>
                                <th>Hochgeladen am</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- FOLDER -->
                            <tr ng-repeat="folder in folders" class="filemanager__folder" ng-click="loadFolder(folder.id)">
                                <td class="filemanager__icon-column"><i class="mdi-file-folder-open"></i></td>
                                <td>{{folder.name}}</td>
                                <td style="color:#999;">Roland Schaub</td>
                                <td style="color:#999;">23. Juni 2015</td>
                                <td></td>
                            </tr>
                            <!-- /FOLDER -->

                            <tr class="filemanager__folder-create">
                                <td class="filemanager__icon-column"></td>
                                <td colspan="3">
                                    <div class="input-field">
                                        <input type="text" ng-model="newFolderName" id="foldername" />
                                        <label for="foldername">Neues Verzeichnis anlegen</label>
                                    </div>
                                </td>
                                <td>
                                    <button ng-click="createNewFolder(newFolderName)" type="button" class="btn">Erstellen</button>
                                </td>
                            </tr>

                            <!-- FILES -->
                            <tr ng-repeat="file in files" class="collection-item avatar" ng-click="toggleSelection(file)" ng-class="{'is-active' : inSelection(file)}">
                                <td class="filemanager__icon-column">
                                <span ng-if="file.thumbnail"><img class="circle responsive-img" src="{{file.thumbnail.source}}" /></span><span ng-if="!file.thumbnail"><i class="mdi-editor-attach-file"></i></span>
                                </td>
                                <td>{{file.name_original}}</td>
                                <td style="color:#999;">{{file.firstname}} {{file.lastname}}</td>
                                <td style="color:#999;">{{file.upload_timestamp}}</td>
                                <td><button class="btn teal lighten-2 right" type="button" ng-show="allowSelection=='true'" ng-click="selectFile(file)"><i class="mdi-navigation-check"></i></button></td>
                            </tr>
                            <!-- /FILES -->

                            <!-- EMPTY -->
                            <tr ng-if="files.length == 0"  class="collection-item">
                                <td class="filemanager__icon-column"></td>
                                <td colspan="4"><strong>Ordner ist leer</strong></td>
                            </tr>
                            <!-- /EMPTY -->
                        </tbody>
                    </table>

                    <br />
                    <label class="btn-floating right teal lighten-3" for="file"><i class="mdi-content-add"></i></label>
                </div>
            </div>

            <div style="display: none;" class="card-panel" flow-init="{target: uploadurl, testChunks:false, headers : { 'Authorization' : bearer }}" flow-name="uploader.flow" flow-files-submitted="startUpload()" flow-complete="complete()">

                <div class="row">
                    <div class="col s6">
                        <input id="file" name="file" type="file" flow-btn />
                    </div>
                    <div class="col s6">
                        <div flow-drop flow-drag-enter="style={border:'4px solid green'}" flow-drag-leave="style={}">
                            Drag And Drop your file here
                        </div>
                    </div>
                </div>
            </div>


        </script>

        <!-- /ANGULAR SCRIPTS -->

        <div class="luya-container">

            <div class="navbar-fixed">
                <nav>
                    <div class="nav-wrapper blue">

                        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>

                        <ul class="left hide-on-med-and-down">
                            <li ng-repeat="item in items" ng-class="{'active' : isActive(item) }">
                                <a ng-click="click(item)" class="navbar__link"><i class="[ {{item.icon}} left ] navbar__icon"></i>{{item.alias}}</a>
                            </li>
                        </ul>
                        <ul class="right">
                            <li>
                                <input type="text" ng-model="searchQuery" />
                            </li>
                            <li ng-mouseenter="showOnlineContainer=true" ng-mouseleave="showOnlineContainer=false">
                                Benutzer online <strong>{{notify.length}}</strong>
                            </li>
                            <li>
                                <a class="dropdown-button" data-hover="true" dropdown data-activates="userMenu"><i class="mdi-action-account-circle right"></i><strong><?php echo $user->email; ?></strong></a>
                            </li>
                        </ul>
                        <ul class="side-nav" id="mobile-demo">
                            <li ng-repeat="item in items" ng-class="{'active' : isActive(item) }">
                                <a ng-click="click(item)" class="navbar__link"><i class="[ {{item.icon}} left ] navbar__icon"></i>{{item.alias}}</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div> <!-- /navbar-fixed -->
            
            <div ng-show="showSearchContainer" style="position: absolute; z-index:999999; border:1px solid red; background-color:white; padding:20px; margin:50px; right:10px;">
                <button ng-click="showSearchContainer=false" class="btn">Close</button>
                <div ng-repeat="item in searchResponse">
                    <h3>{{item.api.alias}}</h3>
                    <table>
                        <tr ng-repeat="row in item.data">
                            <td ng-repeat="(k,v) in row">{{v}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div ng-show="showOnlineContainer" style="position: absolute; z-index:999999; border:1px solid red; background-color:white; padding:20px; margin:50px; right:10px;">
                <ul>
                    <li ng-repeat="row in notify">{{row.firstname}} {{row.lastname}} | {{row.email}} | is active: {{row.is_active}} | inactive since: {{row.inactive_since }} seconds</li>
                </ul>
            </div>
            

            <!-- User dropdown, called by javascript -->
            <ul id="userMenu" class="dropdown-content">
                <li><a href="<?= \Yii::$app->urlManager->createUrl(['admin/default/logout']); ?>">Abmelden</a></li>
                <li><a href="#!">Einstellungen</a></li>
            </ul>
            <!-- /User dropdown -->

            <!-- ANGULAR-VIEW -->
            <div class="luya-container__angular-placeholder module-{{currentItem.moduleId}}" ui-view></div>
            <!-- /ANGULAR-VIEW -->

        </div> <!-- /.luya-container -->

        <?php $this->endBody() ?>

        <script type="text/javascript">$(".button-collapse").sideNav();</script>

    </body>

</html>

<?php $this->endPage() ?>
