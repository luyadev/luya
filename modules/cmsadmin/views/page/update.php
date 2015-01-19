<script type="text/ng-template" id="recursion.html">
<div style="margin-left:20px; background-color:#F0F0F0; border: 1px solid #999; margin-bottom:10px;">

    <div style="background-color:#999; font-size:18px; font-weight:bold; padding:5px;">{{placeholder.label}}</div>

    <div style="padding:10px;">

    <div ng-if="placeholder.__nav_item_page_block_items.length == 0">
        <p><i>There are no blocks yet! drop a block to be the first</i></p>
    </div>

    <div ng-repeat="block in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController" data-drag="true" jqyoui-draggable="" data-jqyoui-options="{revert: true, helper : 'clone'}" ng-model="block">

        <h3 ng-click="toggleEdit()" style="margin:0px; padding:5px; border:1px solid #999;">{{block.name}}</h3>

        <div ng-show="edit" style="background-color:#FFF; padding:10px; border:1px solid #333;">
            <div ng-repeat="field in block.keys">
                <label style="display:block; padding-bottom:5px;"><strong>{{field.label}}</strong>:</label>
                <input type="text" ng-model="data[field.var]" style="width:350px; padding:7px;" />
            </div>
            <a ng-click="save()" style="background-color:black; color:white;">SAVE</a>
        </div>

        <div ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'" style="margin-top:10px;"></div>

   </div>

    <div style="background-color:#000; color:white; padding:20px; margin:0px; text-align:center;" ng-controller="DropBlockController" ng-model="droppedBlock" data-drop="true" jqyoui-droppable="{onDrop: 'onDrop', multiple : true}">
        Drop blocks here!
    </div>

    </div>

</div>
</script>
<div ng-controller="NavController">
<div ng-repeat="lang in langs" ng-controller="NavItemController" style="display:inline-block; width:47%; margin-top:100px; float:left; margin:10px; padding:10px;">

    <h1>{{lang.name}}</h1>

    <div ng-if="item.length == 0" style="background-color:#F0F0F0; padding:20px;">
        Die Seite existiert noch nicht in der Sprache {{lang.name}}. <a ng-click="showadd=!showadd">Jetzt erstellen?</a>

        <div ng-show="showadd">
           <div ng-controller="CmsadminCreateInlineController">
                <create-form data="data"></create-form>
            </div>
        </div>

    </div>

    <div ng-if="item.length != 0" ng-switch on="item.nav_item_type" style="padding-left:10px;">

        <div style="background-color:rgba(255,60,51,.8); padding:15px; color:white;">
            <h2>{{item.title}} ({{item.rewrite}})</h2>
        </div>

        <div ng-switch-when="1"><!-- type:page -->

            <div ng-controller="NavItemTypePageController">
                <p style="border:1px solid #F0F0F0; padding:8px; font-size:11px;">Layout-Name: {{container.nav_item_page.layout_name}}</p>
                <div ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController"  ng-include="'recursion.html'"></div>
            </div>

        </div>

    </div>

</div>
<div style="clear:both; "></div>
<div ng-controller="DroppableBlocksController" style="margin-top:50px; background-color:#F0F0F0;">
    <div ng-repeat="block in blocks" style="border:1px solid #F0F0F0; font-weight:bold; margin:5px; display:inline-block; text-align:center; padding:15px; min-width:200px; background-color:#e1e1e1; border:1px solid #FFF;" data-drag="true" jqyoui-draggable="{placeholder: 'keep', index : {{$index}}}" ng-model="blocks" data-jqyoui-options="{revert: true, helper : 'clone'}">
        <p>{{block.name}}</p>
    </div>
</div>
</div>
