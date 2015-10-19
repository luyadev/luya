<div ng-controller="ActiveWindowGroupAuth">

    <button type="button" ng-click="toggleAll()" class="btn btn-flat">Alle markieren</button>

    <form id="updateSubscription">
        <table>
            <tr ng-repeat="a in auths">
                <td>{{a.id}} - {{ a.module_name }}</td>
                <td><input id="{{a.id}}_base" type="checkbox" ng-model="rights[a.id].base" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_base">{{ a.alias_name}}</label></td>
                <td ng-show="a.is_crud==1"><input id="{{a.id}}_create" type="checkbox" ng-model="rights[a.id].create" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_create">Hinzufügen</label></td>
                <td ng-show="a.is_crud==1"><input id="{{a.id}}_update" type="checkbox" ng-model="rights[a.id].update" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_update">Bearbeiten</label></td>
                <td ng-show="a.is_crud==1"><input id="{{a.id}}_delete" type="checkbox" ng-model="rights[a.id].delete" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_delete">Löschen</label></td>
            </tr>
        </table>
    </form>
    
    <button type="button" ng-click="save(rights)" class="btn btn-flat">Speichern</button>
</div>