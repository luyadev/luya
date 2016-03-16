<?php
use luya\helpers\Url;
?>
<table border="1">
<tr>
	<td><?= $menu->current->title; ?></td>
	<td><a target="_blank" href="<?= Url::toRoute(['/admin/default/index', '#' => '/template/cmsadmin-default-index/update/' . $menu->current->navId], true); ?>">[open in admin]</a></td>
	<td><? if (empty($menu->current->description)): ?><label class="red">No Description found</span><?else:?><label class="green"><?= $menu->current->description; ?></label><?endif;?></td>
	<td>Depth: <?= $menu->current->depth; ?></td>
	<td>isActive: <?= $menu->current->isActive; ?></td>
	<td><? if ($menu->current->moduleName): ?><span>as module: <?= $menu->current->moduleName; ?></span><?else:?>cms page<?endif;?></td>
</tr>
</table>