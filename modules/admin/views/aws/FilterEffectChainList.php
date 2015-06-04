<table border="1" cellpadding="10">
    <tr>
        <td>ID</td>
        <td>Effect-Id</td>
        <td>Filter-Id</td>
        <td>Effect-Name</td>
        <td>Effect Parameters</td>
    </tr>
    <?php foreach ($data as $item): ?>
        <tr>
            <td><?= $item->id; ?></td>
            <td><?= $item->effect_id; ?></td>
            <td><?= $item->filter_id; ?></td>
            <td><?= $item->effect->name; ?></td>
            <td><?= print_r($item->effect_json_values); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
