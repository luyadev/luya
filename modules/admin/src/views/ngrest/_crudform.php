<?php
use luya\admin\Module;

/* @var integer $renderer */
/* @var integer $type 1 = create, 2 = update*/
/* @var boolean $isInline */
/* @var boolean $relationCall */
?>
<?php if ($relationCall): ?>
<div class="ml-3 mr-3">
<?php endif; ?>
<div class="tab-pane tab-padded" role="tabpanel" ng-if="crudSwitchType==<?= $type; ?>" ng-class="{'active' : crudSwitchType==<?= $type; ?>}" <?php if (!$isInline): ?>zaa-esc="closeUpdate()"<?php endif; ?>>
    <form name="formCreate" class="js-form-side-by-side" ng-submit="<?php if ($type==2):?>submitUpdate()<?php else: ?>submitCreate()<?php endif; ?>">
        <?php foreach ($this->context->forEachGroups($renderer) as $key => $group): ?>
            <?php if (!$group['is_default']): ?>
                <div class="card crud-card" ng-init="groupToggler[<?= $key; ?>] = <?= (int) !$group['collapsed']; ?>" ng-class="{'card-closed': !groupToggler[<?= $key; ?>]}">
                    <div class="card-header" ng-click="groupToggler[<?= $key; ?>] = !groupToggler[<?= $key; ?>]">
                        <span class="material-icons card-toggle-indicator">keyboard_arrow_down</span>
                        <?= $group['name']; ?>
                    </div>
                    <div class="card-body">
            <?php endif; ?>

                <?php foreach ($group['fields'] as $field => $fieldItem): ?>
                    <div ng-if="!checkIfFieldExistsInParentRelation('<?= $field; ?>')">
                        <?php foreach ($this->context->createElements($fieldItem, $renderer) as $element): ?>
                            <?= $element['html']; ?>
                        <?php endforeach; ?>
                    </div>
                    <div ng-if="checkIfFieldExistsInParentRelation('<?= $field; ?>')" ng-init="<?= $this->context->ngModelString($renderer, $field); ?>=checkIfFieldExistsInParentRelation('<?= $field; ?>')"></div>
                <?php endforeach; ?>

            <?php if (!$group['is_default']): ?>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-save btn-icon"><?= Module::t($type == 2 ? 'button_save' : 'ngrest_crud_btn_create'); ?></button>
        <?php if ($type == 1): ?>
        <button type="button" class="btn btn-cancel btn-icon" ng-click="closeCreate()"></button>
        <?php else: ?>
        <button type="button" class="btn btn-cancel btn-icon" ng-click="closeUpdate()"></button>
        <?php endif;?>
    </form>
</div>
<?php if ($relationCall): ?>
</div>
<?php endif; ?>