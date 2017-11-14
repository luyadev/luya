# Admin Forms

LUYA provides predefined form to easily add custom forms in admin context which are following the Bootstrap4 forms style guidelines.

Below, the examples show how forms should be used in the admin UI to get the desired results.

## Form with two columns ( label left and input right)

This is a basic example how a text input with a checkbox right next to it could be achieved. 


```html 
<div class="form-group form-side-by-side">
    <div class="form-side form-side-label">
        <label for="text-input">Left text input </label>
    </div>
    <div class="side">
        <input id="text-input" placeholder="text input here ..."  type="text" />
    </div>
</div>
```

If you would line to arrange two forms vertically side by side this could be done with following markup.

```html 
<div class="form-group form-side-by-side">
    <div class="form-side">
        <div class="form-side-label">
            <label for="text-input">Left text input</label>
        </div>
        <div class="form-side">
            <input id="text-input" placeholder="text input here ..."  type="text" />
        </div>
    </div>
    <div class="form-side">
        <div class="form-side">
            <div class="form-side-label">
                <label for="check-input">Left text input</label>
            </div>
            <div class="form-side">
                <input id="check-input" type="checkbox" />
            </div>
        </div>
    </div>
</div>
```

## Generate form with AngularJS 

Using of the angular directive to generate forms as described in the html markup before:

```html 
<?= Angular::text('ngModel', 'Left text input', ['placeholder' => 'text input here ...']); ?>
```

Two forms side by side could be achieved with this markup:

```html 
<div class="form-group form-side-by-side">
    <div class="form-side">
        <?= Angular::text('yourCustomNgModel', 'Left text input', ['placeholder' => 'text input here ...']); ?>
    </div>
    <div class="form-side">
        <?= Angular::checkbox('yourCustomNgModel', 'Right checkbox'); ?>
    </div>
</div>
```
