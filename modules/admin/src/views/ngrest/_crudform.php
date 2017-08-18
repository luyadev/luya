<?php
use luya\admin\Module;

/* @var integer $renderer */
/* @var integer $type */
/* @var boolean $isInline */
?>
<div class="tab-pane tab-padded" role="tabpanel" ng-if="crudSwitchType==<?= $type; ?>" ng-class="{'active' : crudSwitchType==<?= $type; ?>}" <?php if (!$isInline): ?>zaa-esc="closeUpdate()"<?php endif; ?>>
    <form name="formCreate" class="js-form-side-by-side" ng-submit="<?php if ($type==2):?>submitUpdate()<?else:?>submitCreate()<?endif;?>">
        <?php foreach ($this->context->forEachGroups($renderer) as $key => $group): ?>
            <?php foreach ($group['fields'] as $field => $fieldItem): ?>
                    <?php foreach ($this->context->createElements($fieldItem, $renderer) as $element): ?>
                        <?= $element['html']; ?>
                    <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary"><?= Module::t($type == 2 ? 'button_save' : 'ngrest_crud_btn_create'); ?></button>
    </form>
</div>