<script type="text/ng-template" id="reverse.html">
    <a class="Sidebar-Link" ng-click="go(data.id)">{{data.title}}</a>
    <ul class="Sidebar-GroupTitle">
        <li class="Sidebar-Item" ng-repeat="data in data.nodes" ng-include="'reverse.html'"><a href="#">NODE</a></li>
    </ul>
</script>
<div class="Container-Item Container-Item--Sidebar">
<aside class="Sidebar" id="js-sidebar">
    <section class="Sidebar-Group">
            <a ui-sref="custom.cmsadd">Neu Hinzufügen</a>
            <ul ng-controller="TreeController" class="Sidebar-Nav">
                <li class="Sidebar-Item" ng-repeat="data in tree" ng-include="'reverse.html'"></li>
            </ul>
    </section>
    <div class="Sidebar-CurrentIndicator"></div>
</aside>
</div><!--
--><div class="Container-Item Container-Item--Main Container-Item--100 Container-Item--subtractSidebar">
    <section class="Main" role="main" ui-view></section>
</div>
