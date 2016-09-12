<?php
use luya\cms\admin\Module;

?>
<div ng-controller="CmsadminCreateController">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h5 style="text-align:center;"><?= Module::t('view_index_add_title'); ?></h5>
                <create-form data="data"></create-form>
            </div>
        </div>
    </div>
</div>