<div class="container">
    <h5 style="margin-top:100px;"><?= \Yii::$app->siteTitle; ?> Login</h5>
    <div class="card-panel">
        <?php echo \yii\helpers\Html::beginForm('', 'post'); ?>
            <div class="input-field col s12">
                <i class="mdi-content-mail prefix"></i>
                <input type="text" id="email" name="login[email]" value="<?= $model->email; ?>" />
                <label for="email">E-Mail-Adresse</label>
            </div>
            <div class="input-field col s12">
                <i class="mdi-communication-vpn-key prefix"></i>
                <input type="password" id="password" name="login[password]" />
                <label for="password">Passwort</label>
            </div>
            <?php if (count($model->getErrors()) > 0): ?>
             <div class="card-panel red lighten-1 white-text">
                <ul>
                    <?php foreach ($model->getErrors() as $item): ?>
                        <li><?php echo $item[0]; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <input class="btn" type="submit" value="Einloggen">
    <?= \yii\helpers\Html::endForm(); ?>
</div>