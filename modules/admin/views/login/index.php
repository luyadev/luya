<?php $hasError = count($model->getErrors()) > 0; ?>

<div class="login__wrapper">
    <div class="login__innerwrapper">

        <?php
            $options = array('class' => 'login__form');
            if ($hasError == true) {
                $options[ 'class' ] .= ' has-error';
            }
            echo \yii\helpers\Html::beginForm('', 'post', $options);
        ?>
            <div class="login_error">
                <p>
                    <?php if ($hasError): ?>
                        Bitte versuchen Sie es erneut.
                    <?php endif; ?>
                </p>
            </div>

            <div class="login__group">
                <label class="login__label<?php echo($hasError) ? ' error' : ''; ?>" for="login[email]"><span class="fa fa-fw fa-envelope"></span></label><!--
             --><input class="login__input" type="text" id="login[email]" name="login[email]" placeholder="E-Mail" />
            </div>

            <div class="login__group">
                <label class="login__label<?php echo($hasError) ? ' error' : ''; ?>" for="login[password]"><span class="fa fa-fw fa-lock"></span></label><!--
             --><input class="login__input" type="password" id="login[password]" name="login[password]" placeholder="Passwort" />
            </div>

            <input class="login__submit" type="submit" value="Log in">
        <?= \yii\helpers\Html::endForm(); ?>

    </div>
</div>
