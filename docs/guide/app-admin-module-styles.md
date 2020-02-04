# Admin CSS Styles

All [Bootstrap 4](https://getbootstrap.com/) css styles and classes are available in the LUYA ADMIN UI. On top of thi,s LUYA provides generic css classes for buttons with predefined icons and colors.

## Buttons

The Bootstrap4 `btn` class is extended by some predefined colors which are assigned to specific function ( e.g. save, delete, abort). The following classes are available in the whole admin UI:

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

You can combine the btn class with predefined icons, e.g. the use icons can be achieved by simply adding the css class `btn-icon` to the above listed button and the related icon will appear.

```html
<button type="button" class="btn btn-save btn-icon">Save</button>
```

> Please keep in mind that `<input type="button" class="btn btn-icon btn-save" value="Button label" />` does <b>not</b> work because input fields do not support the pseudo css class *:after*. So use the `button` HTML element or something else instead of `input`.

If you would like to display a button with a generic predefined icon use `btn-icon` without a defined class:

```html
<button type="button" class="btn btn-icon"><i class="material-icons">check</i>OK</button>
```

If you want a button `btn-icon` without a background simply add `btn-link`:

```html
<button type="button" class="btn btn-icon btn-link"><i class="material-icons">check</i>Link</button>
```

Below some examples combinations:

```html
<button type="button" class="btn btn-icon btn-save">Save button with icon and text</button>
<button type="button" class="btn btn-cancel">Cancel button without icon</button>
<button type="button" class="btn btn-icon btn-delete"></button> // Delete button without label but predefined icon and colors.
```
 
## Icons

Below, the tables show you which icon stands for what. The full set of usable icons is available under https://material.io/icons.

| Description | Icon            | Name         |
| ------------- | ------------- | ------------- |
| Upload icon | <i class="material-icons">file_upload</i> | file_upload |
| Download icon | <i class="material-icons">file_download</i> | file_download |
| Edit icon | <i class="material-icons">edit</i> | edit |
| Add icon | <i class="material-icons">add_box</i> | add_box |
| Add icon for button | <i class="material-icons">add</i> | add |
| Delete icon | <i class="material-icons">delete</i> | delete |
| Save / Confirm icon | <i class="material-icons">check.png | check |
| Abort / Clear icon | <i class="material-icons">clear</i>  | clear |
| Config icon | <i class="material-icons">settings</i> | settings |
| Settings icon | <i class="material-icons">more_vert</i> | more_vert |
| Visible icon | <i class="material-icons">visibility</i> | visibility |
| Invisible icon | <i class="material-icons">visibility_off</i> | visibility_off |
| Online icon | <i class="material-icons">cloud_queue</i> | cloud_queue |
| Offline icon | <i class="material-icons">cloud_off</i> | cloud_off |
| Sort icon | <i class="material-icons">keyboard_arrow_down</i> <i class="material-icons">keyboard_arrow_up</i> | keyboard\_arrow\_down / keyboard\_arrow\_up |
| Folder icon | <i class="material-icons">folder</i> | folder |
| Create folder | <i class="material-icons">create_new_folder</i> | create_new_folder |


## Forms

The syntax we use to build the forms in LUYA ADMNI UI is as followed:

```html
<div class="form-group form-side-by-side">
    <div class="form-side form-side-label">
        <label>Label</label>
    </div>
    <div class="form-side">
        <input type="text" class="form-control" />
    </div>
</div>
```

### Responsive tables

In addition to the bootstrap `table-responsive` version we have a wrapper to improve the overall behaviour of tables on mobile. You can use the table wrapper as following:

```html
<div class="table-responsive-wrapper">
    <table class="table ..."></table>
</div>
```

In this case you do not have to add the `table-responsive` class to the `table` HTML element to the table.
