<h1>Change Password für id <?= $itemId; ?></h1>
<p>Ändern Sie hier ihre Passwort wie wir es kennen!</p>
<div id="responseSuccess" style="display:none; color:green;"><p>Wunderbar, das passwort wurde gespeichert!</p></div>
<div id="responseError" style="display:none; color:red; padding:20px; font-size:15px;"></div>
<form method="post" id="changePassword">
<table>
    <tr>
        <td>neues pw</td>
        <td><input type="password" name="newpass" /></td>
    </tr>
    <tr>
        <td>neues pw wiederholen</td>
        <td><input type="password" name="newpasswd" /></td>
    </tr>
</table>
<button type="submit" name="submit">SAVE</button>
</form>
<script>
activeWindowRegisterForm('#changePassword', 'ChangeAsync', function(json) {
    if (json.error) {
        $('#responseError').show();
        var text = '';
        for (var e in json.transport) {
            text = text + '<p>' + json.transport[e] + '</p>';
            $('input[name="'+e+'"]', $('#changePassword')).css("border", "1px solid red");
        }
        $('#responseError').html(text);
    } else {
    	$('#responseSuccess').show();
    }
});
</script>
