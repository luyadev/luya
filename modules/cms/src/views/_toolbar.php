<?php
use luya\helpers\Url;
?>
<table id="luya-toolbar-table">
<tr>
	<td>LUYA CMS</td>
	<td><span class="title"><a target="_blank" href="<?= Url::toRoute(['/admin/default/index', '#' => '/template/cmsadmin-default-index/update/' . $menu->current->navId], true); ?>"><?= $menu->current->title; ?></a></span></td>
	<td>Description: <? if (empty($menu->current->description)): ?><label class="label red">No Description found</span><?else:?><label class="label"><?= $menu->current->description; ?></label><?endif;?></td>
	<? if ($menu->current->moduleName): ?><td><span class="label label-bold">Module: <?= $menu->current->moduleName; ?></span></td><?endif;?>
	<td><? if ($menu->current->isHidden): ?><label class="label red">Page is Hidden</label><?else:?><label class="label green">Page is visible</label><?endif;?></td>
	<td><? if($luyaTagParsing): ?><label class="label green">LUYA Tags enabled</label><?else:?><label class="label red">LUYA Tags disabled</label><?endif;?></td>
	<td><? foreach($composition->get() as $key => $value): ?><span class="label"><?= $key; ?>: <?= $value; ?></span><?endforeach;?></td>
	<? if(!empty($properties)): ?><td>Properties: <? foreach($properties as $prop):?><span class="label"><?= $prop['label'] ?>: <?= $prop['value']; ?></span> <?endforeach; ?></td><? endif;?>
	
</tr>
</table>