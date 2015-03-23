<form id="updateSubscription">
<ul>
<? foreach($auth as $item): ?>
    <li>
        <strong><?= $item['alias_name']; ?></strong><br />
        <input type="checkbox" name="rights[<?= $item['id'] ;?>][base]" value="1" <? if(isset($subs[$item['id']])): ?>checked="checked"<?endif;?>' /> Anzeigen
          <? if($item['is_crud']): ?>
          <ul>
              <li><input type="checkbox" name="rights[<?= $item['id'] ;?>][create]" <? if(isset($subs[$item['id']]) && $subs[$item['id']]['create'] == 1): ?>checked="checked"<?endif;?> value="1" /> Hinzufügen</li>
              <li><input type="checkbox" name="rights[<?= $item['id'] ;?>][update]" <? if(isset($subs[$item['id']]) && $subs[$item['id']]['update'] == 1): ?>checked="checked"<?endif;?> value="1" /> Bearbeiten</li>
              <li><input type="checkbox" name="rights[<?= $item['id'] ;?>][delete]" <? if(isset($subs[$item['id']]) && $subs[$item['id']]['delete'] == 1): ?>checked="checked"<?endif;?> value="1" /> Löschen</li>
          </ul>  
          <? endif; ?>
    </li>
<? endforeach; ?>
</ul>
<button type="submit" name="submit">SAVE</button>
</form>
<script>
strapRegisterForm('#updateSubscription', 'UpdateSubscription', function(json) {
	if (json.error) {
		alert('error while update, see console .log');
	} else {
	    alert('nice! update success!');
	}
});
</script>