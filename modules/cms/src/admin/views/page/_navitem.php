<script type="text/ng-template" id="recursion.html">
<h4 class="cmsadmin-container-title">{{placeholder.label}}</h4>
    <div class="card">
        <div class="card-block">
                    <div class="block" ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController">
                        <div class="block-toolbar">
                            <div class="toolbar-item">
                                <!-- <i class="material-icons">title</i>-->
                                <span ng-bind-html="safe(block.full_name)"></span>
                            </div>

                            <div class="toolbar-item ml-auto">
                                <button class="toolbar-button">
                                    <i class="material-icons">content_copy</i>
                                </button>
                            </div>
                            <div class="toolbar-item">
                                <button class="toolbar-button">
                                    <i class="material-icons">visibility</i>
                                </button>
                            </div>
                            <div class="toolbar-item">
                                <button class="toolbar-button">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                            <div class="toolbar-item">
                                <button class="toolbar-button">
                                    <i class="material-icons">clear</i>
                                </button>
                            </div>
                        </div>
                        <div class="block-front" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)" />
                    </div>
    </div>
</div>  
</script>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item nav-item-title">
        <span class="flag flag--{{lang.short_code}}">
            <span class="flag__fallback">{{lang.name}}</span>
        </span>
        <span>{{ item.title }}</span>
    </li>
    <li class="nav-item" ng-repeat="versionItem in typeData">
        <a class="nav-link active" data-toggle="tab" href="#entries" role="tab">
            <span>{{ versionItem.version_alias }}</span>
        </a>
    </li>
    <li class="nav-item nav-item-alternative">
        <a class="nav-link" href="#en" role="tab">
            <i class="material-icons">add</i>
            New Version
        </a>
    </li>
    <li class="nav-item nav-item-alternative nav-item-icon ml-auto">
        <a class="nav-link" href="#en" role="tab">
            <i class="material-icons">edit</i>
        </a>
    </li>
    <li class="nav-item nav-item-alternative nav-item-icon">
        <a class="nav-link" href="#en" role="tab">
            <i class="material-icons">open_in_new</i>
        </a>
    </li>
</ul>
<div class="cmsadmin-page">
    <div class="row">
        <div class="col-xl-12" ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'" />
    </div>
</div>