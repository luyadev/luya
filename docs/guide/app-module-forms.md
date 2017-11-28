
# Working with forms

This example shows how to use a {{yii\widgets\ActiveForm}} in a controller which uses a [[ngrest-model.md]].

## Controller logic

```php
public function actionIndex()
{
    $model = new ExampleFormModel();

    // Validate model
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        // All data submitted is valid
        // Do stuff with the data
        
        // Save the model
        if ($model->save()) {
            Yii::$app->session->setFlash('success');

            // Now you could redirect to a success page or
            // print a success message in the index view
            // return $this->redirect(['/module/controller/index']);
        }
    }

    return $this->render('index', [
        'model' => $model // pass model to the view to display extra informations
    ]);
}
```

## View file

The corresponding view file `views/controller/index.php` could look like this:

```php
<?php if(Yii::$app->session->getFlash('success')): ?>
    <p>Thank you for your request</p>
<?php else: ?>
        
    <? $form = \yii\widgets\ActiveForm::begin(); ?> <!-- start of form -->

    <?= $form->field($model, 'field1'); ?> <!-- example field definition -->
    <?= $form->field($model, 'field2'); ?> <!-- example field definition -->
    <?= $form->field($model, 'field3'); ?> <!-- example field definition -->

    <?= yii\helpers\Html::submitButton('Verify', ['class' => 'button']) ?>

    <? \yii\widgets\ActiveForm::end(); ?> <!-- end of form -->

<?php endif; ?>
```

The `success` variable is used to determine if the model was successfully saved - that's only required if you do not redirect the user to another page.

See [Yii 2 ActiveForm](http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html) for more information.

## Image and file uploads

In order to enable image and file upload you can just use the file input:

```php
<?= $activeForm->field($form, 'attachment[]')->fileInput(['multiple' => true, 'accept' => 'file/*']) ?>
```

Validation inside the model:

```php
[['attachment'], StorageUploadValidator::class, 'multiple' => true],
```

In order to display the data inside the NgRest CRUD system you have to apply the {{luya\admin\ngrest\plugins\FileArray}} plugin for the given field name:

```php
/**
 * @inheritdoc
 */
public function ngRestAttributeTypes()
{
    return [
        // ...
        'attachment' => 'fileArray',
    ];
}
```