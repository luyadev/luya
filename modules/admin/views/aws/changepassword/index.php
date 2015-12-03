<div ng-controller="ActiveWindowChangePassword">
    <p><?= \admin\Module::t('aws_changepassword_info'); ?></p>
    <div class="row">
        <div class="col s12">
            
            <div class="row">
                <div class="input-field col s6">
                    <input id="newpass" type="password" ng-model="newpass" class="validate">
                    <label for="newpass"><?= \admin\Module::t('aws_changepassword_new_pass'); ?></label>
                </div>
                
                <div class="input-field col s6">
                    <input id="newpasswd" type="password" ng-model="newpasswd" class="validate">
                    <label for="newpasswd"><?= \admin\Module::t('aws_changepassword_new_pass_retry'); ?></label>
                </div>
            </div>
            
            <div class="alert alert--danger" ng-show="error">
                <ul>
                    <li ng-repeat="msg in transport">{{msg}}</li>
                </ul>
            </div>
            
            <button class="btn" ng-click="submit()" type="button"><?= \admin\Module::t('button_save'); ?></button>
            
        </div>
    </div>
    <div class="row">
        <div class="alert alert--success" ng-show="submitted && !error">{{ transport.message }}</div>
    </div>
</div>