# Working with Forms

This example shows how to use a [ActiveForm](http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html) in a controller.  
It uses a [NgRest Model](ngrest-model.md) with a extra field `success` besides its project specific structure.

```php
public function actionIndex()
{
    $model = new ExampleFormModel();

    // Validate model
    if($model->load(Yii::$app->request->post()) && $model->validate()) {
        // All data submitted is valid
        // Do stuff with the data
        // Set success to true if everything worked
        $model->success = true;
        
        // Save the model
        $model->save();

        // Now you could redirect to a success page or
        // print a success message in the index view
        // return $this->redirect(['/module/controller/index']);
    }

    return $this->render('index', [
        'model' => $model // pass model to the view to display extra informations
    ]);
}
```

The corresponding view file could look like this:  
File: `views/controller/index.php`

```php
<? if($model->success == true): ?>
    <p>Thank you for your request</p>
<? else: ?>
        
    <? $form = ActiveForm::begin(); ?> <!-- start of form -->

    <?= $form->field($model, 'field1'); ?> <!-- example field definition -->
    <?= $form->field($model, 'field2'); ?> <!-- example field definition -->
    <?= $form->field($model, 'field3'); ?> <!-- example field definition -->

    <?= yii\helpers\Html::submitButton('Verify', ['class' => 'button']) ?>

    <? ActiveForm::end(); ?> <!-- end of form -->

<? endif; ?>
```

The `success` variable is used to determine if the model was successfully saved - that's only requried if you don't redirect the user to another page.

See [Yii 2 ActiveForm](http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html) for more informations.
