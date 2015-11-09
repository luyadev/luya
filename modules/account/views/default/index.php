<h1>Einloggen</h1>

<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<button type="submit">Submit</button>

<?php \yii\widgets\ActiveForm::end();?>

<ul>
    <li><a href="<?= \luya\helpers\Url::toManager('account/default/lostpass'); ?>">Passwort vergessen Formular</a></li>
    <li><a href="<?= \luya\helpers\Url::toManager('account/register/index'); ?>">Noch keinen Account? Jetzt registrieren.</a></li>
</ul>
