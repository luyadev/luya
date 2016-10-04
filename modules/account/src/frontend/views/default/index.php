<h1>Login</h1>
<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'password')->passwordInput() ?>

<button type="submit">Submit</button>

<?php \yii\widgets\ActiveForm::end();?>
