<?php

function rightsColumns($navId)
{
    echo "<td>[ x ]</td><td>[ ]</td><td>[ xx ]</td>";
}

function recursive($row, $index = 0)
{
    if (empty($row)) {
        return false;
    }
    
    foreach ($row as $item) {
        
        echo "<tr><td>";
        for ($i = 1; $i <= $index; $i++) {
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        echo $item['title'] . "</td>";
        echo rightsColumns(1);
        echo "</tr>";
        
        recursive($item['__children'], $index+1);
    }
}

?>
<div class="card">
    <h1>Zugriffs Berechtigungen</h1>
    
    
    <table class="striped">
        <? foreach($data as $row): ?>
        <tr>
            <td colspan="100"><strong>Container: <?= $row['container']['name']; ?></strong></td>
        </tr>
        
        <?= recursive($row['items'], 0); ?>
        
        <? endforeach; ?>
    </table>
    
</div>