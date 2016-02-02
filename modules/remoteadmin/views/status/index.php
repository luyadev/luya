<div class="card-panel">
<h3>Remote Admin</h3>
<p>All Remote-Date will be cached for <strong>2 minutes</strong>. You can us the reload button to flush the whole page cache.</p>
<p>Current LUYA Version is <?= $currentVersion['version']; ?> <i>(release date <?= date("d.m.Y", strtotime($currentVersion['time'])); ?>)</i></p>
<table class="bordered hoverable">
<thead>
<tr>
    <th>Id</th>
    <th>Url</th>
    <th>Time *</th>
    <th>YII_DEBUG</th>
    <th>Transfer Exceptions</th>
    <th>Admins Online</th>
    <th>YII_ENV</th>
    <th>LUYA Version</th>
    <th>Yii Version</th>
    <th></th>
</tr>
</thead>
<?php $err = false; foreach ($sites as $site): ?>
    <tr>
        <td><?= $site['data']['id']; ?></td>
        <td><a href="<?= $site['data']['url']; ?>" target="_blank"><?= $site['data']['url']; ?></a></td>
        
        <?php if ($site['remote']): ?>
        	<td><?= round($site['remote']['app_elapsed_time'], 2); ?> seconds</td>
            <td <?= $this->context->colorize($site['remote']['app_debug']); ?>><?= $this->context->textify($site['remote']['app_debug']); ?></td>
            <td <?= $this->context->colorize($site['remote']['app_transfer_exceptions']); ?>><?= $this->context->textify($site['remote']['app_transfer_exceptions']); ?></td>
            
            <td><?= $site['remote']['admin_online_count']; ?></td>
            
            <td><?= $site['remote']['app_env']; ?></td>
            
            <td <?= $this->context->versionize($site['remote']['luya_version']); ?>><?= $site['remote']['luya_version']; ?></td>
            <td><?= $site['remote']['yii_version']; ?></td>
            <td>
                <a href="<?= $site['data']['url']; ?>/admin" target="_blank">
                    <button class="btn-flat  btn--bordered">
                        <i class="material-icons">exit_to_app</i>
                    </button>
                </a>
            </td>
        <?php else: $err = true; ?>
            <td colspan="7"><div style="background-color:#FF8A80; padding:4px; color:white;">We are unable to retrieve dat from this Remote Page.</div></td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</table>
<p><small>* Time: Returns the total elapsed time since the start of the request on the Remote application. Its the speed of the application, not the time elapsed to make the remote request.</small></p>
</div>

<?php if ($err): ?>
<div class="card-panel red accent-1">
<p>Wenn das abrufen der Remote-Seite einen Fehler ausgibt könnten diese folgende Ursachen haben:</p>
<ul>
    <li>Die Seite liegt hinter einem HTTPAUTH schutz, du kannst diesen unter instanzen definieren.</li>
    <li>Die Seite verfügt nicht über das <b>Admin-Module</b>. Das Admin-Modul ist zwingend notwending um Remote-Informationen anzuzeigen.</li>
</ul>
</div>
<?php endif; ?>