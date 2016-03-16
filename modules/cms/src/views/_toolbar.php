<?php
use luya\helpers\Url;
?>
<table border="1">
<tr>
	<td><?= $menu->current->title; ?></td>
	<td><a target="_blank" href="<?= Url::toRoute(['/admin/default/index', '#' => '/template/cmsadmin-default-index/update/' . $menu->current->navId], true); ?>">[open in admin]</a></td>
	<td><? if (empty($menu->current->description)): ?><label class="red">No Description found</span><?else:?><label class="green"><?= $menu->current->description; ?></label><?endif;?></td>
	<td>hidden: <? var_dump($menu->current->isHidden); ?></td>
	<td><? if ($menu->current->moduleName): ?><span>as module: <?= $menu->current->moduleName; ?></span><?else:?>cms page<?endif;?></td>
	<td>Localisation:<? foreach($composition->get() as $key => $value): ?> [<?= $key; ?>: <?= $value; ?>]<?endforeach;?></td>
	<td>Properties: <? print_r(Yii::$app->page->getProperties()); ?></td>
	<td>Luya Tags: <? var_dump($luyaTagParsing); ?></td>
</tr>
</table>