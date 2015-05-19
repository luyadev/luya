<!-- 
<h1>FileManager Directive</h1>
<storage-file-manager is-hidden="false" selection="false"></storage-file-manager>

<hr />
 -->
<h1>File Upload Directive</h1>
<div ng-controller="UploadController">
<form ng-submit="save()">

    <table>

        <tr>
            <td>Datei</td>
            <td><storage-file-upload ng-model="bildId"></storage-file-upload></td>
        </tr>

    </table>

    <button type="submit">SENDEN</button>

</form>
</div>

<hr />

<h1>Image Upload Directive</h1>
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
