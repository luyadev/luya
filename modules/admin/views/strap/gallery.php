<div ng-controller="StrapGalleryController">
    <div class="card-panel" flow-init="{target: getStrapCallbackUrl('upload') , testChunks:false}" flow-files-submitted="$flow.upload()" flow-complete="loadImages()">
        <h4>Hochladen</h4   >
        <div class="row">
            <div class="s6">
                <input type="file" flow-btn/>
            </div>
            <div class="s6">
                <div flow-drop flow-drag-enter="style={border:'4px solid green'}" flow-drag-leave="style={}">
                    Drag And Drop your file here
                </div>
            </div>
        </div>
    </div>
      

    <div class="row">
        <div style="margin-top:20px;" class="col s1" ng-repeat="image in images"><img src="{{image.source}}" class="responsive-img" border="0" /></div>
    </div>
</div>