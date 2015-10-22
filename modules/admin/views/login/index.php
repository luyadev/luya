<div class="container" style="margin-top:150px;">
    <h5><?= Yii::$app->siteTitle; ?> Login</h5>
    <div class="card-panel" style="padding:60px;">
        
        <form method="post" id="loginForm">
            <div class="input-field col s12">
                <i class="material-icons prefix">mail</i>
                <input type="text" id="email" name="login[email]" value="<?= $model->email; ?>" />
                <label for="email">E-Mail-Adresse</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">vpn_key</i>
                <input type="password" id="password" name="login[password]" />
                <label for="password">Passwort</label>
            </div>
            <button class="waves-effect waves-light btn right" type="submit">Einloggen <i class="material-icons">send</i></button>
            <div style="clear:both;"></div>
        </form>
        
        <form method="post" id="secureForm" style="display:none;">
            
            <p style="padding-bottom:20px;">Geben Sie den Sicherheitscode ein, der Ihnen per E-Mail geschickt wurde.</p>
            
            <div class="input-field col s12">
                <i class="material-icons prefix">lock_outline</i>
                <input type="text" name="secure_token" id="secure_token" />
                <label for="secure_token">Sicherheitscode</label>
            </div>
            
            <button class="waves-effect waves-light btn right" type="submit">Einloggen <i class="material-icons">send</i></button>
            <button class="waves-effect waves-teal btn-flat right" type="button" id="abortToken">Abbrechen</button>
            
            <div style="clear:both;"></div>
        </form>
        
        <div class="preloader-wrapper big active" id="spinner" style="display:none;">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        
        <div class="card-panel red lighten-1 white-text" id="errorsContainer" style="display:none;"></div>
        
        <div class="card-panel green accent-4 white-text" id="success" style="display:none;">
            <p>Sie haben sich erfolgreich eingeloggt. Falls Sie nicht weiter geleitet werden. Klicken Sie bitte hier.</p>
        </div>
        
    </div>
</div>