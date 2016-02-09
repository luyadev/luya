<div ng-controller="ActiveWindowGalleryController">
    <div class="col s8">
    	<storage-file-manager selection="true" only-images="true" />
    </div>
    <div class="col s4" style="background-color:#F0F0F0;">
        <div style="padding:10px;">
            <h5><?php echo \admin\Module::t('aws_gallery_images')?></h5>
            <div ng-show="isEmptyObject(files)">
                <p><?php echo \admin\Module::t('aws_gallery_empty')?></p>
            </div>
            <div class="col s3" ng-repeat="file in files" style="min-height:180px;">
                <button type="button" ng-click="remove(file)" class="btn btn-flat"><i class="material-icons">delete</i></button>
                <img ng-src="{{file.source}}" height="150" class="responsive-img" />
            </div>
        </div>
    </div>
</div>