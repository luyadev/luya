NGREST FIELD CONFIGS
==========

Below an overview of all allowed field configs


fields
-----------

| Name				  									|  Description
| ------------------- 									| -------------
| text				  									| creates a basic input text field
| textarea		  	  									| creates a textarea input field
| password												| creates a text field with type password
| [select](start-ngrest-field-select.md)				| creates a select dropdown with options
| ace													| Creates an ace editor
| togglestatus                                          | Creates a checkbox
| image													| Creates an image uploader and returns the imageId to the obeserved field
| file													| Creates a file upload and returns the fileId to the observed field
| [checkboxReleation](start-ngrest-field-checkboxreleation.md) | Createa checkbox part based on a refTable/viaTable.
| datepicker											| Creates an input field with a datepicker popover (model value: dd-mm-yyyy)



field implicits
----------------

| Name					| Description
|-----------------------| -------------------
| required				| makes the previous field required (based on the set id)

