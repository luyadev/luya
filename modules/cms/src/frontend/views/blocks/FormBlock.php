<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
*/
$hideForm = false;
?>
<?php if ($this->varValue('emailAddress')): ?>
<?= $this->varValue('headline', null, '<h3>{{headline}}</h3>'); ?>
<?php if ($this->extraValue('name') && $this->extraValue('email') && $this->extraValue('message')): ?>
    <?php if ($this->extraValue('mailerResponse') == 'success'): $hideForm = true;?>
        <div class="alert alert-success"><?= $this->extraValue('sendSuccess'); ?></div>
    <?php else: ?>
        <div class="alert alert-danger"><?= $this->extraValue('sendError'); ?></div>
    <?php endif; ?>
<?php endif; ?>
    <?php if (!$hideForm): ?>
    <form class="form-horizontal" role="form" method="post">
        <input type="hidden" name="_csrf" value="<?= $this->extraValue('csrf'); ?>" />
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label"><?= $this->extraValue('nameLabel'); ?></label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" placeholder="<?= $this->extraValue('namePlaceholder'); ?>" value="<?= $this->extraValue('name'); ?>">
            <?php if (!$this->extraValue('nameErrorFlag')): ?>
                <p class="text-danger"><?= $this->extraValue('nameError'); ?></p>
            <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label"><?= $this->extraValue('emailLabel'); ?></label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="<?= $this->extraValue('emailPlaceholder'); ?>" value="<?= $this->extraValue('email'); ?>">
                <?php if (!$this->extraValue('emailErrorFlag')): ?>
                    <p class="text-danger"><?= $this->extraValue('emailError'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="message" class="col-sm-2 control-label"><?= $this->extraValue('messageLabel'); ?></label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="4" name="message"><?= $this->extraValue('message'); ?></textarea>
                <?php if (!$this->extraValue('messageErrorFlag')): ?>
                    <p class="text-danger"><?= $this->extraValue('messageError'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input id="submit" name="submit" type="submit" value="<?= $this->extraValue('sendLabel'); ?>" class="btn btn-primary">
            </div>
        </div>
    </form>
    <?php endif; ?>
<?php endif; ?>