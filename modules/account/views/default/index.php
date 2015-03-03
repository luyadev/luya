<? $form = \yii\widgets\ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <button type="submit">Submit</button>
    
    <?php \yii\widgets\ActiveForm::end();?>