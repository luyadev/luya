<h1>Effekt Einfügen</h1>
<? foreach($effectModel::find()->all() as $item): $json = json_decode($item->imagine_json_params, true); ?>
    <div style="border:1px solid #F0F0F0; padding:10px; margin:10px;">
        <h2><?= $item->name; ?> (<?= $item->imagine_name; ?>)</h2>
        <form class="addEffect">
            <input type="hidden" name="effectId" value="<?= $item->id; ?>" />
            <? foreach($json['vars'] as $cfg): ?>
            <div>
                <label><?= $cfg['label']; ?></label>
                <input type="text" name="effectArguments[<?= $cfg['var']; ?>]" />
            </div>
            <? endforeach; ?>
            <button type="submit">Einfügen</button>
        </form>
    </div>
<? endforeach; ?>

<hr />
<h1>Aktueller Effekt Chain</h1>

<script>
$('.addEffect').each(function(value) {
    console.log($(this));
    strapRegisterForm($(this), 'addEffect', function(json) {
        console.log(json);
    });
});
</script>
