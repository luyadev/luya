<?php if (!$state): ?>
<?php $form = \yii\widgets\ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal']]); ?>
<?php echo $form->field($model, 'gender')->dropdownlist(['' => 'Bitte wählen', 0 => 'Frau', 1 => 'Herr']); ?>
<?php echo $form->field($model, 'company') ?>
<?php echo $form->field($model, 'firstname') ?>
<?php echo $form->field($model, 'lastname') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'password')->passwordInput() ?>
<?php echo $form->field($model, 'password_confirm')->passwordInput() ?>
<?php echo $form->field($model, 'street') ?>
<?php echo $form->field($model, 'zip') ?>
<?php echo $form->field($model, 'city') ?>
<?php echo $form->field($model, 'country') ?>
<?php echo $form->field($model, 'subscription_newsletter')->checkbox(); ?>
<?php echo $form->field($model, 'subscription_medianews')->checkbox(); ?>
<button type="submit">Submit</button>
<?php echo $form->errorSummary($model); ?>
<?php \yii\widgets\ActiveForm::end(); ?>
<?php endif; ?>

<?php if ($state == 1): ?>
<p>Sie haben sich erfolgreich registriert, bitte bestätigten Sie den Link welcheln wir Ihnen per E-Mail versendet haben.</p>
<?php elseif ($state == 2): ?>
<p>Erfolgreich registriert. Sie werden von einem Administrator freigeschalten.</p>
<?php elseif ($state == 3): ?>
<p>Sie haben sich erfolgreich registriert und könnnen sich jetzt einloggen</p>
<a href="<?= $this->url('account/default/index'); ?>">Login</a>
<?php endif; ?>