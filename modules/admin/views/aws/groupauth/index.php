<form id="updateSubscription">
<button type="button" class="btn" onclick="toggleAll(true)"><strong>Alle Markieren</strong></button>
<button type="button" class="btn" onclick="toggleAll(false)"><strong>Alle Entziehen</strong></button>
<button type="button" class="btn" onclick="toggleSelector('view', true)">Alle nur Anzeigen</button>
<button type="button" class="btn" onclick="toggleSelector('create', true)">Alle nur Erstellen</button>
<button type="button" class="btn" onclick="toggleSelector('update', true)">Alle nur Bearbeiten</button>
<button type="button" class="btn" onclick="toggleSelector('delete', true)">Alle nur Löschen</button>
<table class="bordered hoverable">
<?php $last = null; foreach($auth as $item):?>
<?php if ($last !== $item['module_name']): ?>
    <thead>
        <tr><th colspan="4"><?= ucfirst($item['module_name']); ?> <button class="btn-flat" type="button" onclick="toggleSelector('<?= $item['module_name']; ?>', true)">+</button><button class="btn-flat" type="button" onclick="toggleSelector('<?= $item['module_name']; ?>', false)">-</button></th></tr>
    </thead>
    <?php endif; ?>
<tr>
    <td>
        <input id="<?= $item['module_name']; ?>_base_<?= $item['id']; ?>" class="<?=$item['module_name'];?> view" type="checkbox" name="rights[<?= $item['id'];?>][base]" value="1" <?php if (isset($subs[$item['id']])): ?>checked="checked"<?endif;?> />
        <label for="<?= $item['module_name']; ?>_base_<?= $item['id']; ?>"><?= $item['alias_name']; ?></label>    
    </td>
    <?php if ($item['is_crud']): ?>
    <td>
        <input id="<?= $item['module_name']; ?>_create_<?= $item['id']; ?>" class="<?=$item['module_name'];?> create" type="checkbox" name="rights[<?= $item['id'];?>][create]" <?php if (isset($subs[$item['id']]) && $subs[$item['id']]['create'] == 1): ?>checked="checked"<?endif;?> value="1" />
        <label for="<?= $item['module_name']; ?>_create_<?= $item['id']; ?>">Hinzufügen</label>
    </td>
    <td>
        <input id="<?= $item['module_name']; ?>_update_<?= $item['id']; ?>" class="<?=$item['module_name'];?> update" type="checkbox" name="rights[<?= $item['id'];?>][update]" <?php if (isset($subs[$item['id']]) && $subs[$item['id']]['update'] == 1): ?>checked="checked"<?endif;?> value="1" />
        <label for="<?= $item['module_name']; ?>_update_<?= $item['id']; ?>">Bearbeiten</label>
    </td>
    <td>
        <input id="<?= $item['module_name']; ?>_del_<?= $item['id']; ?>" class="<?=$item['module_name'];?> delete" type="checkbox" name="rights[<?= $item['id'];?>][delete]" <?php if (isset($subs[$item['id']]) && $subs[$item['id']]['delete'] == 1): ?>checked="checked"<?endif;?> value="1" />
        <label for="<?= $item['module_name']; ?>_del_<?= $item['id']; ?>">Löschen</label>    
    </td>
    <?php else: ?>
        <td colspan="3">&nbsp;</td>
    <?php endif; ?>
</tr>
<?php $last = $item['module_name']; endforeach; ?>
</table>
<button style="margin-top:20px;" type="submit" name="submit" class="btn">Speichern</button>
</form>
<script>
activeWindowRegisterForm('#updateSubscription', 'UpdateSubscription', function(json) {
	if (json.error) {
		alert('error while update, see console .log');
	} else {
		 Materialize.toast('Die neuen Gruppen Berechtigungen wurden gespeichert.', 3000) // 4000 is the duration of the toast
		 $('#activeWindowModal').closeModal();
	}
});

var toggleAll = function(value) {
	$('input[type=checkbox]', '#updateSubscription').each(function(k, v) {
	    $(v).prop("checked", value);
	});
}

var toggleSelector = function(classSelector, value) {
	$('.' + classSelector, '#updateSubscription').each(function(k, v) {
	    $(v).prop("checked", value);
	});
}
</script>
