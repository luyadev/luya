<div ng-controller="DefaultController">
<div class="main__item main__item--left">

    <nav class="subnav main__fixeditem" role="navigation">
        <div class="subnav__group" ng-repeat="item in items">

            <h2 class="subnav__grouptitle">{{item.name}}</h2>
            <ul class="subnav__list" role="menu" ng-repeat="sub in item.items" on-finish="onSubMenuFinish">

                <li class="subnav__item" role="menuitem">
                    <a class="subnav__link" role="link" ng-click="click(sub)">
                        <span class="subnav__text fa fa-fw {{sub.icon}}">{{sub.alias}}</span>
                    </a>
                </li> <!-- ./subnav__item -->

            </ul> <!-- ./subnav__list -->

        </div> <!-- ./subnav__group -->
    </nav> <!-- ./subnav -->

</div><!-- ./main__left
--><div class="main__item main__item--right" ui-view>

    <h1>Dashboard</h1>
    <div ng-repeat="item in dashboard">
    
        <h2><i class="fa {{ item.menu.icon}} "></i> {{ item.menu.alias }}</h">
        <div ng-repeat="log in item.data">
            <p>{{ log.firstname }} {{ log.lastname}} hat einen Datensatz
            
                <strong ng-if="log.is_update == 1">bearbeitet</strong>
                <strong ng-if="log.is_insert == 1">hinzugefügt</strong>
            
                am {{ log.timestamp_create * 1000 | date:"dd.MM.yyyy ' um ' HH:mm" }} Uhr.
            </p>
        </div>
    
    </div>
    
</div><!-- ./main__right -->
</div>