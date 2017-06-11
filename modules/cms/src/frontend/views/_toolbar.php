<?php
use luya\helpers\Url;
use luya\cms\frontend\Module;

?>
<div id="luya-cms-toolbar-wrapper">
    <div id="luya-cms-toolbar">
        <div class="luya-cms-toolbar__button luya-cms-toolbar__button--info">
            <div class="luya-cms-toolbar__button-text">
                <?php if ($menu->current->isHidden): ?>
                    <i class="material-icons" alt="<?= Module::t('tb_visible_not_alt'); ?>" title="<?= Module::t('tb_visible_not_alt'); ?>">visibility_off</i>
                <?php else: ?>
                    <i class="material-icons" alt="<?= Module::t('tb_visible_alt'); ?>" title="<?= Module::t('tb_visible_alt'); ?>">visibility</i>
                <?php endif; ?>
                <?php if ($menu->current->type == 2): ?>
                    <span class="luya-cms-toolbar__badge luya-cms-toolbar__margin-left">
                        Modul: <strong><?= $menu->current->moduleName; ?></strong>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="luya-cms-toolbar__button">
            <a target="_blank" href="<?= Url::toInternal(['/admin/default/index', '#' => '!/template/cmsadmin~2Fdefault~2Findex/update/' . $menu->current->navId], true); ?>">
                <i alt="<?= Module::t('tb_edit_alt'); ?>" title="<?= Module::t('tb_edit_alt'); ?>"  class="material-icons">mode_edit</i>
            </a>
        </div>
        <div class="luya-cms-toolbar__button">
            <a class="luya-cms-toolbar__container-toggler" href="javascript:void(0);" onclick="toggleDetails(this, 'luya-cms-toolbar-seo-container')">
                <?php if ($seoAlertCount > 0): ?><span class="luya-cms-toolbar__badge luya-cms-toolbar__badge--danger"><?= $seoAlertCount; ?></span><?php endif;?> <span><?= Module::t('tb_seo'); ?></span> <i class="material-icons">keyboard_arrow_down</i>
            </a>
        </div>
        <div class="luya-cms-toolbar__button">
            <a class="luya-cms-toolbar__container-toggler" href="javascript:void(0);" onclick="toggleDetails(this, 'luya-cms-toolbar-composition-container')">
                <span class="luya-cms-toolbar__badge"><?= count($composition->get()); ?></span> <span><?= Module::t('tb_composition'); ?></span> <i class="material-icons">keyboard_arrow_down</i>
            </a>
        </div>
        <?php if (!empty($properties)): ?>
            <div class="luya-cms-toolbar__button">
                <a class="luya-cms-toolbar__container-toggler" href="javascript:void(0);" onclick="toggleDetails(this, 'luya-cms-toolbar-properties-container')">
                    <span class="luya-cms-toolbar__badge"><?= count($properties); ?></span> <span><?= Module::t('tb_properties'); ?></span> <i class="material-icons">keyboard_arrow_down</i>
                </a>
            </div>
        <?php endif; ?>
        <div class="luya-cms-toolbar__pull-right">
            <div class="luya-cms-toolbar__logo">
                <a href="https://luya.io" target="_blank">
                    <?= Luya\Boot::VERSION; ?>
                    <img alt="LUYA <?= Luya\Boot::VERSION; ?>" title="LUYA <?= Luya\Boot::VERSION; ?>" src="data:image/png;base64,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" />  
                </a>
            </div>
        </div>
    </div>
    <div id="luya-cms-toolbar-seo-container" class="luya-cms-toolbar__container">
        <div class="luya-cms-toolbar__list">
            <div class="luya-cms-toolbar__list-entry">
                <div class="luya-cms-toolbar__list-entry-left">
                    <label><?= Module::t('tb_seo_title'); ?></label>
                </div>
                <div class="luya-cms-toolbar__list-entry-right">
                    <p>
                        <?= $menu->current->title; ?>
                    </p>
                </div>
            </div>
            <div class="luya-cms-toolbar__list-entry">
                <div class="luya-cms-toolbar__list-entry-left">
                    <label><?= Module::t('tb_seo_description'); ?></label>
                </div>
                <div class="luya-cms-toolbar__list-entry-right">
                    <p>
                        <?php if (empty($menu->current->description)): ?>
                            <span class="luya-cms-toolbar__text--danger"><?= Module::t('tb_seo_description_notfound'); ?></span>
                        <?php else: ?>
                            <span class="luya-cms-toolbar__text--success"><?= $menu->current->description; ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="luya-cms-toolbar__list-entry">
                <div class="luya-cms-toolbar__list-entry-left">
                    <label><?= Module::t('tb_seo_link'); ?></label>
                </div>
                <div class="luya-cms-toolbar__list-entry-right">
                    <p>
                        <?= $menu->current->link; ?>
                    </p>
                </div>
            </div>
            <div class="luya-cms-toolbar__list-entry">
                <div class="luya-cms-toolbar__list-entry-left">
                    <label><?= Module::t('tb_seo_keywords'); ?></label>
                </div>
                <div class="luya-cms-toolbar__list-entry-right">
                	<?php if (empty($keywords)): ?>
                		<p class="luya-cms-toolbar__text--danger"><?= Module::t('tb_seo_keywords_notfound'); ?></p>
                	<?php else: ?>
                		<?php if ($seoAlertCount > 0): ?>
                		<p class="luya-cms-toolbar__badge--warning"><?= Module::t('tb_seo_warning'); ?></p>
                		<?php endif; ?>
                		<ul class="luya-cms-toolbar__no-bullets">
                			<?php foreach ($keywords as $keyword): ?>
                			 <li><span class="luya-cms-toolbar__badge<?= $keyword[1] > 0 ? ' luya-cms-toolbar__badge--success' : ' luya-cms-toolbar__badge--danger'  ?>"><?= $keyword[1]; ?></span> <span><?= $keyword[0]; ?></span></li>
                			<?php endforeach; ?>
                		</ul>
                	<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="luya-cms-toolbar-composition-container" class="luya-cms-toolbar__container">
        <div class="luya-cms-toolbar__list">
            <?php foreach ($composition->get() as $key => $value): ?>
                <div class="luya-cms-toolbar__list-entry">
                    <div class="luya-cms-toolbar__list-entry-left">
                        <label><?= $key ?></label>
                    </div>
                    <div class="luya-cms-toolbar__list-entry-right">
                        <p>
                            <?= $value; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if (!empty($properties)): ?>
        <div id="luya-cms-toolbar-properties-container" class="luya-cms-toolbar__container">
            <div class="luya-cms-toolbar__list">
                <?php foreach ($properties as $prop): ?>
                    <div class="luya-cms-toolbar__list-entry">
                        <div class="luya-cms-toolbar__list-entry-left">
                            <label><?= $prop['label'] ?></label>
                        </div>
                        <div class="luya-cms-toolbar__list-entry-right">
                            <p>
                            	<?php if (is_object($prop['value'])): ?>
                            		Type Object
                            	<?php elseif (is_array($prop['value'])): ?>
                            		Type Array: <?= count($prop['value']); ?> item(s);
                            	<?php elseif (is_scalar($prop['value'])): ?>
                            		<?= $prop['value']; ?>
                            	<?php else: ?>
                            		Type Undefined
                            	<?php endif; ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="luya-cms-toolbar-container__toggler">
        <a href="javascript:void(0);" onclick="toggleLuyaToolbar()">
            <i class="material-icons luya-cms-toolbar__arrow">keyboard_arrow_down</i>
            <?php if ($seoAlertCount > 0): ?>
            <div class="luya-cms-toolbar-container__toggler-badge"><?= $seoAlertCount; ?></div>
            <?php endif; ?>
        </a>
    </div>
</div>