<h1>Tagging</h1>
<div ng-controller="ActiveWindowTagController">
    <div class="row card-panel">
        <div class="col s10 input-field">
            <input type="text" ng-model="newTagName" />
            <label>Ein neuer Tag erfassen</label>
        </div>
        <div class="col s2 input-field">
            <button type="button" ng-click="saveTag()" class="btn btn-flat"><i class="material-icons">send</i> Speichern</button>
        </div>
    </div>
    <div class="row card-panel" style="margin-top:40px;">
        <div class="col s12">
            <ul>
                <li><label>Suchen:</label><input type="text" ng-model="searchString" /></li>
                <li ng-repeat="tag in tags | filter:searchString | orderBy:'name'">
                    <input id="{{tag.id}}_tag" ng-click="saveRelation(tag, relation[tag.id])" type="checkbox" ng-model="relation[tag.id]" ng-true-value="1" ng-false-value="0" /><label for="{{tag.id}}_tag"></label> {{tag.name}}
                </li>
            </ul>
        </div>
    </div>
</div>