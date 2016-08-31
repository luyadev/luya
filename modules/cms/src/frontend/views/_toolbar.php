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
            <a target="_blank" href="<?= Url::toRoute(['/admin/default/index', '#' => '/template/cmsadmin-default-index/update/' . $menu->current->navId], true); ?>">
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
                    <img alt="LUYA <?= Luya\Boot::VERSION; ?>" title="LUYA <?= Luya\Boot::VERSION; ?>" src="data:image/png;base64,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" />

                    <?= Luya\Boot::VERSION; ?>
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
                                <?= is_array($prop['value']) ? count($prop['value']) . ' item(s)' : $prop['value']; ?>
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