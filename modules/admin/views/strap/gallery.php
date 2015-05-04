<h3>Bilder</h3>
<? foreach($images as $img): $image = \yii::$app->luya->storage->image->get($img['image_id']); ?>
    <img src="<?= $image->source; ?>" border="0" height="100" />
<? endforeach; ?>
<hr />
<h3>Hochladen</h3>
<div flow-init="{target: getStrapCallbackUrl('upload') , testChunks:false}"
     flow-files-submitted="$flow.upload()"
     flow-file-success="$file.msg = $message"
     >

  <input type="file" flow-btn/>
  Input OR Other element as upload button

  <table border="1">
    <tr ng-repeat="file in $flow.files">
        <td>{{$index+1}}</td>
        <td>{{file.name}}</td>
        <td>{{file.msg}}</td>
    </tr>
  </table>
  
  <p><strong>Bilder werden nach dem Upload noch nicht angezeigt</strong></p>
</div>