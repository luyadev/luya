# Generate a Form within a Block

This is an example of how to generate a block with a form represented by a model and using the active form widget to generate the output.

## Generate the Model

First of all generate the model with your custom roles and store in `app/models`:

```php
<?php

namespace app\models;

use yii\base\Model;

class TestModel extends Model
{
    public $name = null;
    public $email = null;
    public $text = null;
	
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['name', 'text'], 'string'],
            [['email'], 'email'],
        ];
    }
	
    public function sendMail()
    {
        // this is what happens on success, like sending a mail
		
        return Yii::$app->mail
            ->compose('Success Subject', 'You got mail: ' . print_r($this->attributes, true))
            ->address('hello@luya.io')
            ->send();
    }
}
```
					
## Prepare the Block 

Now the Model respons needs to be assigned to the frontend view trough the extra vars section. extra vars are somewhat equals to when assign vars into the view in a controller context. You can assign anything into your view files.

```php
class MyFormBlock extends \luya\cms\base\PhpBlock
{
    // ... configs, icons, etc.
    public function extraVars()
    {
        return [
            'model' => $this->prepareModel(),
        ];
    }
	
    public function prepareModel()
    {
        $model = new TestModel();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->sendMail();
            Yii::$app->session->setFlash('myBlockFormSuccess');
            Yii::$app->response->redirect(Yii::$app->request->url);
			
            return Yii::$app->end();
        }
 
        return $model;
    }
}
```
				
Now the model is available in the extra vars section as model.

### Render the Form in the View

Now we have to render the form in the view file with help of the ActiveForm Widget.

```php
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
<?php if (Yii::$app->session->getFlash('myBlockFormSuccess')): ?>
    <div class="alert alert-success">The form has been sent! Thank you.</div>
<?php else: ?>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($this->extraValue('model'), 'name') ?>
        <?= $form->field($this->extraValue('model'), 'email') ?>
        <?= $form->field($this->extraValue('model'), 'text')->textarea() ?>
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary-outline']) ?>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
```
