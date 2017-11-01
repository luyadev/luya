<?php
use luya\admin\Module;

?>
<div ng-controller="ActiveWindowGalleryController" class="row">
    <div class="col-md-8">
    	<storage-file-manager selection="true" only-images="true" />
    </div>
    <div class="col-md-4">
        <h5><?= Module::t('aws_gallery_images')?></h5>
            <div ng-show="files.length == 0" class="alert alert-info">
                <?= Module::t('aws_gallery_empty')?>
            </div>
            <div class="row">
                <div class="col-sm-3" ng-repeat="(key, file) in files track by key">
                  <div class="card mb-3">
                        <img class="card-img-top" ng-src="{{file.source}}" />
                        <div class="card-block p-1">
                            <p class="card-text">
                                <small class="text-muted">
                                    <?php if ($sortIndexFieldName): ?>
                                    <button type="button" class="btn btn-link" ng-show="!$first" ng-click="moveUp(file, key)"><i class="material-icons">keyboard_arrow_left</i></button>
                                    <button type="button" class="btn btn-link" ng-show="!$last" ng-click="moveDown(file, key)"><i class="material-icons">keyboard_arrow_right</i></button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-link float-right" ng-click="remove(file, key)"><i class="material-icons">delete</i></button>
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>