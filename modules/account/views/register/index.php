<? if (!$state): ?>
<? $form = \yii\widgets\ActiveForm::begin(['id' => 'login-form','options' => ['class' => 'form-horizontal']]); ?>
<?= $form->field($model, 'gender')->dropdownlist(['' => 'Bitte wählen', 0 => 'Frau', 1 => 'Herr']); ?>
<?= $form->field($model, 'company') ?>
<?= $form->field($model, 'firstname') ?>
<?= $form->field($model, 'lastname') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_confirm')->passwordInput() ?>
<?= $form->field($model, 'street') ?>
<?= $form->field($model, 'zip') ?>
<?= $form->field($model, 'city') ?>
<?= $form->field($model, 'country') ?>
<?= $form->field($model, 'subscription_newsletter')->checkbox(); ?>
<?= $form->field($model,  'subscription_medianews')->checkbox(); ?>
<button type="submit">Submit</button>
<?= $form->errorSummary($model); ?>
<? \yii\widgets\ActiveForm::end(); ?>
<? endif; ?>

<? if ($state == 1): ?>
<p>Sie haben sich erfolgreich registriert, bitte bestätigten Sie den Link welcheln wir Ihnen per E-Mail versendet haben.</p>
<? elseif ($state == 2): ?>
<p>Erfolgreich registriert. Sie werden von einem Administrator freigeschalten.</p>
<? elseif ($state == 3): ?>
<p>Sie haben sich erfolgreich registriert und könnnen sich jetzt einloggen</p>
<a href="<?= luya\helpers\Url::toManager('account/default/index'); ?>">Login</a>
<? endif; ?>