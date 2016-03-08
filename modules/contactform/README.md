Contact Form Module
===================

This module provides a very fast and secure way to create customizable contact forms:

### install

```json
"luyadev/luya-module-contactform" : "1.0.0-beta5"
```


### configure module

```php
'modules' => [
    // ...
    'contactform' => [
        'class' => 'contactform\Module',
        'attributes' => [
            'name', 'email', 'street', 'city', 'tel', 'message',
        ],
        'rules' => [
            [['name', 'email', 'street', 'city', 'message'], 'required'],
            ['email', 'email'],
        ],
        'recipients' => [
            'admin@example.com',
        ],
    ],  
    // ...
],
```

To defined the attribute labels you can configure the module as followed:

```php
'attributeLabels' => [
    'email' => 'E-Mail',
],
```

By default LUYA will wrap the value into the `Yii::t('app', $value)` functions so you are able to translate the attributes labels. The above exmaple would look like this `Yii::t('app', 'E-Mail')`.

### create view file

```php
<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var object $model Contains the model object based on DynamicModel yii class.
 * @var boolean $success Return true when successfull sent mail and validated
 */
?>

<? if ($success): ?>
    <div class="alert alert-success">The form has been submited successfull.</div>
<? else: ?>
    <? $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name'); ?>
    <?= $form->field($model, 'email'); ?>
    <?= $form->field($model, 'street'); ?>
    <?= $form->field($model, 'city'); ?>
    <?= $form->field($model, 'tel'); ?>
    <?= $form->field($model, 'message')->textarea(); ?>
    
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    
    <? ActiveForm::end(); ?>
<? endif; ?>
```

when the form validation success the variable `$success` will be true, in addition a Yii2 flash mesage `Yii::$app->session->setFlash('contactform_success')` with the key-name `contactform_success` will be set.