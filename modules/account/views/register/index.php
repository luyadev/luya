<? if(!empty($errors)): ?>
    <ul>
    <? foreach($errors as $field => $msgs): ?>
        <li><?= $field; ?>: <?php print_r($msgs); ?></li>
    <? endforeach; ?>
    </ul>
<? endif; ?>
<form method="post">
    Vorname: <input type="text" name="Register[firstname]" /><br />
    Nachname: <input type="text" name="Register[lastname]" /><br />
    E-Mail: <input type="text" name="Register[email]" /><br />
    Password: <input type="text" name="Register[password]" /><br />
    Password Wiederholung: <input type="text" name="Register[password_confirm]" /><br />
    <button type="submit">Register</button>
</form>