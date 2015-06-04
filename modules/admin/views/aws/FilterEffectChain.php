<h1>Effekt Einfügen</h1>
<?php foreach ($effectModel::find()->all() as $item): $json = json_decode($item->imagine_json_params, true); ?>
    <div style="border:1px solid #F0F0F0; padding:10px; margin:10px;">
        <h2><?= $item->name; ?> (<?= $item->imagine_name; ?>)</h2>
        <form class="addEffect">
            <input type="hidden" name="effectId" value="<?= $item->id; ?>" />
            <?php foreach ($json['vars'] as $cfg): ?>
            <div>
                <label><?= $cfg['label']; ?></label>
                <input type="text" name="effectArguments[<?= $cfg['var']; ?>]" />
            </div>
            <?php endforeach; ?>
            <button type="submit">Einfügen</button>
        </form>
    </div>
<?php endforeach; ?>

<hr />
<h1>Aktueller Effekt Chain</h1>
<div id="chain"></div>

<script>
$('.addEffect').each(function(value) {
	activeWindowRegisterForm($(this), 'addEffect', function(json) {
        loadChain();
    });
});

var loadChain = function() {
	activeWindowAsyncGet('loadEffects', {}, function(json) {
	    $(json.transport).each(function(key, item) {
		    $('#chain').html(item['html']);
	    });
	});
};

loadChain();
</script>
