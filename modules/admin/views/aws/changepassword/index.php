<div ng-controller="ActiveWindowChangePassword">
    <p>Geben Sie ein neues Passwort für den Benutzer ein. Das neue Passwort muss mindestens <strong>6 Zeichen</strong> lang sein.</p>
    <div class="row">
        <div class="col s12">
            
            <div class="row">
                <div class="input-field col s6">
                    <input id="newpass" type="password" ng-model="newpass" class="validate">
                    <label for="newpass">Neues Passwort</label>
                </div>
                
                <div class="input-field col s6">
                    <input id="newpasswd" type="password" ng-model="newpasswd" class="validate">
                    <label for="newpasswd">Passwort wiederholen</label>
                </div>
            </div>
            
            <div class="alert alert--danger" ng-show="error">
                <ul>
                    <li ng-repeat="msg in transport">{{msg}}</li>
                </ul>
            </div>
            
            <button class="btn" ng-click="submit()" type="button">Speichern</button>
            
        </div>
    </div>
    <div class="row">
        <div class="alert alert--success" ng-show="submitted && !error">Das neue Passwort wurde erfolgreich gesetzt.</div>
    </div>
</div>