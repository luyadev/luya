<div class="card-panel">
<h3>Remote Admin</h3>
<p>All Remote-Date will be cached for <strong>2 minutes</strong>. You can us the reload button to flush the whole page cache.</p>
<p>Current LUYA Version is <strong><?php echo $currentVersion['version']; ?></strong> <i>(release date <?php echo date("d.m.Y", strtotime($currentVersion['time'])); ?>)</i></p>
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
        <td><?php echo $site['data']['id']; ?></td>
        <td><a href="<?php echo $site['data']['url']; ?>" target="_blank"><?php echo $site['data']['url']; ?></a></td>
        
        <?php if ($site['remote']): ?>
        	<td><?php echo round($site['remote']['app_elapsed_time'], 2); ?> seconds</td>
            <td <?php echo $this->context->colorize($site['remote']['app_debug']); ?>><?php echo $this->context->textify($site['remote']['app_debug']); ?></td>
            <td <?php echo $this->context->colorize($site['remote']['app_transfer_exceptions']); ?>><?php echo $this->context->textify($site['remote']['app_transfer_exceptions']); ?></td>
            
            <td><?php echo $site['remote']['admin_online_count']; ?></td>
            
            <td><?php echo $site['remote']['app_env']; ?></td>
            
            <td <?php echo $this->context->versionize($site['remote']['luya_version']); ?>><?php echo $site['remote']['luya_version']; ?></td>
            <td><?php echo $site['remote']['yii_version']; ?></td>
            <td>
                <a href="<?php echo $site['data']['url']; ?>/admin" target="_blank">
                    <button class="btn-flat  btn--bordered">
                        <i class="material-icons">exit_to_app</i>
                    </button>
                </a>
            </td>
        <?php else: $err = true; ?>
            <td colspan="7"><div style="background-color:#FF8A80; padding:4px; color:white;">Unable to retrieve data from the Remote Page.</div></td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</table>
<p><small>* Time: Returns the total elapsed time since the start of the request on the Remote application. Its the speed of the application, not the time elapsed to make the remote request.</small></p>
</div>

<?php if ($err): ?>
<div class="card-panel red accent-1">
<p>If the request to a remote page returns an error, the following issues could have caused your request:</p>
<ul>
    <li>The requested website is secured by a httpauth authorization, you can add the httpauth credentials in the page configuration section.</li>
    <li>The requested website url is wrong or not valid anymire. Make sure the url is correctly added with its protocol.</li>
    <li>The requested website remote token is not defined in the config of the website itself or your enter secure token is wrong.</li>
</ul>
</div>
<?php endif; ?>