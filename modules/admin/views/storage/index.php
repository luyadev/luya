<h1>Filemanager Storage Engine</h1>


<div>
   <button type="button">Datei Hochladen</button>
   <button type="button">Dateiamanger öffnen</button>
</div>

<div ng-controller="UploadController">
<form ng-submit="save()">

    <table>
    
        <tr>
            <td>Bild</td>
            <td><storage-upload-form ng-model="bildId"></storage-upload-form></td>
        </tr>
    
    </table>

    <button type="submit">SENDEN</button>
    
</form>
</div>