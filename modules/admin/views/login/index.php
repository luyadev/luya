<h2>Login</h2>
<?= \yii\helpers\Html::beginForm(); ?>
<?php if (count($model->getErrors()) > 0): ?>
    <?php print_r($model->getErrors()); ?>
<?php endif; ?>
<div class="form-group">
    <label>E-Mail-Adresse:</label>
    <input type="text" name="login[email]" class="form-control" />
</div>
<div class="form-group">
    <label>Passwort:</label>
    <input type="password" name="login[password]" class="form-control" />
</div>
<button type="submit" class="btn btn-default">Login</button>
<?= \yii\helpers\Html::endForm(); ?>
