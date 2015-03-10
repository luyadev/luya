
<h1>FILE UPLOAD</h1>
<div ng-controller="UploadController">
<form ng-submit="save()">

    <table>
    
        <tr>
            <td>Bild</td>
            <td><storage-file-upload ng-model="bildId"></storage-file-upload></td>
        </tr>
    
    </table>

    <button type="submit">SENDEN</button>
    
</form>
</div>

<h1>IMAGE UPLOAD</h1>
<div ng-controller="UploadController">
<form ng-submit="save()">

    <table>
    
        <tr>
            <td>Bild</td>
            <td><storage-image-upload ng-model="bildId"></storage-image-upload></td>
        </tr>
    
    </table>

    <button type="submit">SENDEN</button>
    
</form>
</div>
