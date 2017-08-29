# Admin CSS Styles

All [Bootstrap 4](https://v4-alpha.getbootstrap.com/) css style classes are available in der Admin Interface.
On top of this LUYA provides generic css classes for buttons with predefined icons and colors.

## Predefined Buttons

LUYA Admin has a set of Class you can use inside your admin views, this makes sure to render the elements the same in the whole UI. 

Below a set of buttons:

```html
<button type="button" class="btn btn-save">Save</button>
<button type="button" class="btn btn-delete">Delete</button>
<button type="button" class="btn btn-cancel">Cancel</button>
<button type="button" class="btn btn-edit">Edit</button>
<button type="button" class="btn btn-add">Add</button>
<button type="button" class="btn btn-help">Help</button>
<button type="button" class="btn btn-download">Download</button>
<button type="button" class="btn btn-upload">Upload</button>
<button type="button" class="btn btn-config">Configuration</button>
```

You can either combine the btn class with predefined icons, to do so simply add the css class `btn-icon` to the above listed buttons and the related icon will appear.

```html
<button type="button" class="btn btn-save btn-icon">Save</button>
```
> Please keep in mind that ```<input type="button" class="btn btn-icon btn-save" value="Button label" /> ``` does <b>not</b> work because input fields don`t support the pseudo css class ```:after``.


If you would like to display a button without predefined icon use `btn-icon` without a defined class:

```html
<button type="button" class="btn btn-icon"><i class="material-icons">check</i>OK</button>
```


and if you want a button `btn-icon` without a background simply add `btn-link`:
```html
<button type="button" class="btn btn-icon btn-link"><i class="material-icons">check</i>Link</button>
```

Below some examples

```html
<button type="button" class="btn btn-icon btn-save">Safe button with icon and text</button>
<button type="button" class="btn btn-cancel">Cancel button without icon</button>
<button type="button" class="btn btn-icon btn-delete"></button> // Delete button without label but predefined icon and colors.
```
 
## Which icon stands for what

Material Design Icons: https://material.io/icons/

| Description | Icon            | Name         |
| ------------- | ------------- | ------------- |
| Upload icon | ![file_upload](img/app-admin-styles/default-icons/file_upload.png) | file_upload |
| Download icon | ![file_upload](img/app-admin-styles/default-icons/file_download.png) | file_download |
| Edit icon | ![file_upload](img/app-admin-styles/default-icons/edit.png) | edit |
| Add icon | ![file_upload](img/app-admin-styles/default-icons/add_box.png) | add_box |
| Add icon for button | ![file_upload](img/app-admin-styles/default-icons/add.png) | add_box |
| Delete icon | ![file_upload](img/app-admin-styles/default-icons/delete.png) | delete |
| Save / Confirm icon | ![file_upload](img/app-admin-styles/default-icons/check.png) | check |
| Abort / Clear icon | ![file_upload](img/app-admin-styles/default-icons/clear.png) | clear |
| Config icon | ![file_upload](img/app-admin-styles/default-icons/settings.png) | settings |
| Settings icon | ![file_upload](img/app-admin-styles/default-icons/more_vert.png) | more_vert |
| Visible icon | ![file_upload](img/app-admin-styles/default-icons/visibility.png) | visibility |
| Invisible icon | ![file_upload](img/app-admin-styles/default-icons/visibility_off.png) | visibility_off |
| Online icon | ![file_upload](img/app-admin-styles/default-icons/cloud_queue.png) | cloud_queue |
| Offline icon | ![file_upload](img/app-admin-styles/default-icons/cloud_off.png) | cloud_off |
| Sort icon | ![file_upload](img/app-admin-styles/default-icons/keyboard_arrow_down.png) ![file_upload](img/app-admin-styles/default-icons/keyboard_arrow_up.png) | keyboard\_arrow\_down / keyboard\_arrow\_up |
| Folder icon | ![file_upload](img/app-admin-styles/default-icons/folder_open.png) | folder_open |



