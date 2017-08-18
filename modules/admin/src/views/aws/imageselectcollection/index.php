<?php
use luya\admin\Module;

?>
<div ng-controller="ActiveWindowGalleryController" class="row">
    <div class="col-md-8">
    	<storage-file-manager selection="true" only-images="true" />
    </div>
    <div class="col-md-4">
        <h5><?= Module::t('aws_gallery_images')?></h5>
            <div ng-show="isEmptyObject(files)" class="alert alert-info">
                <?= Module::t('aws_gallery_empty')?>
            </div>
        <div class="row">
            <div class="col-md-2" ng-repeat="file in files">
                <button class="btn btn-outline-danger btn-sm" type="button" ng-click="remove(file)" style="position:absolute;"><i class="material-icons">delete</i></button>
                <img class="img-fluid img-thumbnail" ng-src="{{file.source}}" /><br />
            </div>
        </div>
    </div>
</div>