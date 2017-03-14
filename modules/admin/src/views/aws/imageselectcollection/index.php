<?php
use luya\admin\Module;

?>
<div ng-controller="ActiveWindowGalleryController">
    <div class="col s8">
    	<storage-file-manager selection="true" only-images="true" />
    </div>
    <div class="col s4" style="background-color:#F0F0F0;">
        <div style="padding:10px;">
            <h5><?= Module::t('aws_gallery_images')?></h5>
            <div ng-show="isEmptyObject(files)">
                <p><?= Module::t('aws_gallery_empty')?></p>
            </div>
            <div class="col s3" ng-repeat="file in files">
                <div class="aws-gallery__image-wrapper">
                    <div class="aws-gallery__image-index">{{ $index+1 }}</div>
                    <img class="aws-gallery__image" ng-src="{{file.source}}" height="auto" width="100%" />
                    <button class="aws-gallery__image-btn" type="button" ng-click="remove(file)"><i class="material-icons">delete</i></button>
                </div>
            </div>
        </div>
    </div>
</div>