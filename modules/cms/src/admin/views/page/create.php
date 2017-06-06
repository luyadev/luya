<?php
use luya\cms\admin\Module;
?>
<div class="luya__content" ng-controller="CmsadminCreateController">
    <h1><?= Module::t('view_index_add_title'); ?></h1>
    <create-form data="data"></create-form>
</div>