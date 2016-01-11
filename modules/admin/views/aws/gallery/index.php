<div ng-controller="ActiveWindowGalleryController">
    <div class="col s8">
    	<storage-file-manager selection="true" only-images="true" />
    </div>
    <div class="col s4" style="background-color:#F0F0F0;">
        <div style="padding:10px;">
            <h5>Album Bilder</h5>
            <div ng-show="isEmptyObject(files)">
                <p>Sie haben noch keine Bilder für diese Album ausgewählt. Klicken Sie im Dateimanager (links) auf die gewünschten Bilder, welche Sie in das Album hinzufügen möchten.</p>
            </div>
            <div class="col s3" ng-repeat="file in files" style="min-height:180px;">
                <button type="button" ng-click="remove(file)" class="btn btn-flat"><i class="material-icons">delete</i></button>
                <img ng-src="{{file.source}}" height="150" class="responsive-img" />
            </div>
        </div>
    </div>
</div>