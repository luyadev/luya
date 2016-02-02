<div ng-controller="ActiveWindowChangePassword">
    <p><?= \admin\Module::t('aws_changepassword_info'); ?></p>
    <div class="row">
        <div class="col s12">
            
            <div class="row">
                <div class="input input--text col s6">
                	<label for="newpass" class="input__label"><?= \admin\Module::t('aws_changepassword_new_pass'); ?></label>
                	<div class="input__field-wrapper">
                    	<input id="newpass" type="password" ng-model="newpass" class="validate input__field input--vertical">
                    </div>
                </div>
                
                <div class="input input--text col s6">
                	<label for="newpasswd" class="input__label"><?= \admin\Module::t('aws_changepassword_new_pass_retry'); ?></label>
                	<div class="input__field-wrapper">
                    	<input id="newpasswd" type="password" ng-model="newpasswd" class="validate input__field input--vertical">
                    </div>
                </div>
            </div>
            
            <button class="btn" ng-click="submit()" type="button"><?= \admin\Module::t('button_save'); ?></button>
            
        </div>
    </div>
    <div class="row" ng-show="submitted && error">
        <div class="alert alert--danger" >
            <ul>
                <li ng-repeat="msg in errorMessage">{{msg | json }}</li>
            </ul>
        </div>
    </div>
    <div class="row" ng-show="submitted && !error">
        <div class="alert alert--success">{{ transport }}</div>
    </div>
</div>