<div ng-controller="ActiveWindowGalleryController">
    <div class="card-panel">
        <div>
        <label class="floating-button-label left" ngf-select ngf-multiple="true" ng-model="uploadingfiles">
            <span class="btn-floating">
                <i class="mdi-file-file-upload"></i>
            </span>
            <span class="floating-button-label__label">Datei hinzufügen</span>
        </label>
        </div>
    </div>

    <div class="row">
        <div style="margin-top:20px;" class="col s1" ng-repeat="image in images"><img ng-src="{{image.source}}" class="responsive-img" border="0" /></div>
    </div>
</div>