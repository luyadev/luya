<form id="updateSubscription">
<button type="button" onclick="toggleAll(true)"><strong>Alle Markieren</strong></button>
<button type="button" onclick="toggleAll(false)"><strong>Alle Entziehen</strong></button>
<button type="button" onclick="toggleSelector('view', true)">Alle nur Anzeigen</button>
<button type="button" onclick="toggleSelector('create', true)">Alle nur Erstellen</button>
<button type="button" onclick="toggleSelector('update', true)">Alle nur Bearbeiten</button>
<button type="button" onclick="toggleSelector('delete', true)">Alle nur Löschen</button>
<table border="0" style="border-spacing: 10px;  border-collapse: separate;">
<?php $last = null; foreach ($auth as $item):?>
<?php  if ($last !== $item['module_name']): ?>
    <tr><td colspan="9"><h1><?= ucfirst($item['module_name']); ?> <button type="button" onclick="toggleSelector('<?= $item['module_name']; ?>', true)">+</button><button type="button" onclick="toggleSelector('<?= $item['module_name']; ?>', false)">-</button></h1></td></tr>
<?php endif; ?>
<tr>
    <td><strong><?= $item['alias_name']; ?>:</strong></td>
    <td><input class="<?=$item['module_name'];?> view" type="checkbox" name="rights[<?= $item['id'];?>][base]" value="1" <?php if (isset($subs[$item['id']])): ?>checked="checked"<?endif;?>' /></td>
    <td>Anzeigen</td>
    <?php if ($item['is_crud']): ?>
    <td><input class="<?=$item['module_name'];?> create" type="checkbox" name="rights[<?= $item['id'];?>][create]" <?php if (isset($subs[$item['id']]) && $subs[$item['id']]['create'] == 1): ?>checked="checked"<?endif;?> value="1" /></td>
    <td>Hinzufügen</td>
    <td><input class="<?=$item['module_name'];?> update" type="checkbox" name="rights[<?= $item['id'];?>][update]" <?php if (isset($subs[$item['id']]) && $subs[$item['id']]['update'] == 1): ?>checked="checked"<?endif;?> value="1" /></td>
    <td>Bearbeiten</td>
    <td><input class="<?=$item['module_name'];?> delete" type="checkbox" name="rights[<?= $item['id'];?>][delete]" <?php if (isset($subs[$item['id']]) && $subs[$item['id']]['delete'] == 1): ?>checked="checked"<?endif;?> value="1" /></td>
    <td>Löschen</td>
    <?php else: ?>
        <td colspan="6">&nbsp;</td>
    <?php endif; ?>
</tr>
<?php $last = $item['module_name']; endforeach; ?>
</table>

<button type="submit" name="submit"><h2>Speichern</h2></button>
<div id="success" style="display:none; color:green;">
    Die neuen Berechtigungen wurden gespeichert, Sie können diesen Dialog nun schliessen. <p><i>Tipp: Drücken Sie ESC</i></p>
</div>
</form>
<script>
strapRegisterForm('#updateSubscription', 'UpdateSubscription', function(json) {
	if (json.error) {
		alert('error while update, see console .log');
	} else {
		$('#success').show();
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
