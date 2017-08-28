<?php
use luya\admin\Module;
use luya\admin\ngrest\aw\CallbackFormWidget;

/**
 * @var $this \luya\admin\ngrest\base\ActiveWindowView
 * @var $form luya\admin\ngrest\aw\CallbackFormWidget
 */
?>
<div>
    <p><?= Module::t('aws_changepassword_info'); ?></p>

    <?php $form = CallbackFormWidget::begin(['callback' => 'save', 'buttonValue' => Module::t('button_save')]); ?>
    
    <?= $form->field('newpass', Module::t('aws_changepassword_new_pass'))->passwordInput(); ?>
    <?= $form->field('newpasswd', Module::t('aws_changepassword_new_pass_retry'))->passwordInput(); ?>

    <?php $form::end(); ?>

    <button type="button" class="btn btn-icon btn-save">UND DAS NO MIT TEXT</button>
    <button type="button" class="btn btn-cancel">Cancel</button>
    <button type="button" class="btn btn-icon btn-cancel">Cancel mit Icon</button>
    <button type="button" class="btn btn-icon btn-cancel btn-nolabel"></button>
</div>