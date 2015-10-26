<h1>Tagging</h1>
<div ng-controller="ActiveWindowTagController">
    <div class="col s12">
        <ul>
            <li ng-repeat="tag in tags">
                <input id="{{tag.id}}_tag" ng-click="saveRelation(tag, relation[tag.id])" type="checkbox" ng-model="relation[tag.id]" ng-true-value="1" ng-false-value="0" /><label for="{{tag.id}}_tag"></label> {{tag.name}}
            </li>
        </ul>
    </div>
</div>