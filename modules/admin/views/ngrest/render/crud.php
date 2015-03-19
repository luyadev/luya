<script>
strapCallbackUrl = '<?= $strapCallbackUrl;?>';
ngrestConfigHash = '<?= $config->getNgRestConfigHash(); ?>';
zaa.bootstrap.register('<?=$config->getNgRestConfigHash(); ?>', function($scope, $controller) {
    /* extend class */
    $.extend(this, $controller('CrudController', { $scope : $scope }));
    /* local controller config */
    $scope.config.apiListQueryString = '<?= $crud->apiQueryString('list'); ?>';
    $scope.config.apiUpdateQueryString = '<?= $crud->apiQueryString('update'); ?>';
    $scope.config.apiEndpoint = '<?=$config->getRestUrl();?>';
    $scope.config.list = <?=json_encode($crud->getFields('list'));?>;
    $scope.config.create = <?=json_encode($crud->getFields('create'));?>;
    $scope.config.update = <?=json_encode($crud->getFields('update'));?>;
    $scope.config.ngrestConfigHash = '<?= $config->getNgRestConfigHash(); ?>';
});
</script>

<div ng-controller="<?=$config->getNgRestConfigHash(); ?>" ng-init="init()" style="width: 100%; height: 100%;">

    <div class="toolbar">

        <h3 class="toolbar__title" role="heading">
            <span class="fa fa-fw <?= $config->getOption('fa-icon'); ?>"></span> <?= $config->getOption('title'); ?>
        </h3>

        <div class="toolbar__items">
            <div class="toolbar__item">
                <button class="button button--green" role="button" ng-click="toggleCreate()">
                    <span class="button__text fa fa-plus-circle"> Hinzufügen</span>
                </button>
            </div> <!-- ./toolbar__item -->

            <!-- 
            <div class="toolbar__item">
                <a class="toolbar__link" role="link">
                    <button class="button button--green" role="button">
                        <span class="button__text">Als CSV exportieren</span>
                    </button>
                </a>
            </div>
             --> <!-- ./toolbar__item -->
        </div> <!-- ./toolbar__items -->

    </div>

    <div class="crud">

        <div class="crud__table">

            <div class="crud__toolbar toolbar">

                <div class="toolbar__item">

                    <p class="crud__count">Es werden <b>{{data.list.length}}</b> Einträge angezeigt.</p>

                </div> <!-- ./toolbar__item -->

                <div class="toolbar__item toolbar__item--pullright">
                    <a class="toolbar__link" role="link">
                        <input class="search__input" ng-model="search" type="text" focus-me="showCrudList" placeholder="Filtern..."/>
                    </a>

                </div> <!-- ./toolbar__item -->

            </div>

            <table class="table">

                <thead>
                    <tr>
                        <?php foreach ($crud->list as $item): ?>
                            <th class="table__column table__column--head"><?= $item['alias']; ?></th>
                        <?php endforeach; ?>
                        <th class="table__column table__column--head">Aktionen</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="table__row" ng-repeat="item in data.list | filter:search">
                        <?php foreach ($crud->list as $item): ?>
                            <td class="table__column"><?= $crud->createElement($item, $crud::TYPE_LIST); ?></td>
                        <?php endforeach; ?>
                        <td class="table__column table__column--actions">
                            <button class="button button--yellow" ng-click="toggleUpdate(item.<?= $config->getRestPrimaryKey(); ?>, $event)">
                                <span class="button__icon fa fa-fw fa-edit"></span>
                            </button>
                            <?php foreach ($crud->getStraps() as $item): ?>
                                <button class="button button--yellow" ng-click="getStrap('<?= $item['strapHash']; ?>', item.<?= $config->getRestPrimaryKey();?>, $event)">
                                    <span class="button__text"><?=$item['alias']; ?></span>
                                </button>
                            <?php endforeach; ?>

                            <!--<a href="delete-overlay.html" class="button button--red"><span class="button__icon fa fa-fw fa-trash"></span></a>-->
                        </td>
                    </tr>



                </tbody>

            </table>

        </div> <!-- ./crud__table -->

    </div> <!-- ./crud -->

    <!-- CREATE-CONTAINER -->
    <div class="overlay overlay--green" ng-class="{'is-active': toggler.create}">
        <div class="overlay__wrapper">
            <div class="overlay__content" ng-show="toggler.create">

                <div class="overlay__header">
                    <p><span class="fa fa-fw fa-pencil"></span> Neuen Eintrag erstellen</p>

                    <div class="overlay__hide">
                        <span class="fa fa-fw fa-eye-slash"></span>
                    </div>
                </div>

                <div class="overlay__body">

                    <form class="form" role="form" ng-submit="submitCreate()">

                        <?php foreach ($crud->create as $k => $item): ?>
                            <div class="form__item form__inputgroup">
                                <label class="form__label"><?= $item['alias'] ?>:</label>
                                <?= $crud->createElement($item, $crud::TYPE_CREATE); ?>
                                <div class="form__active"></div>
                            </div>
                        <?php endforeach; ?>

                        <div class="form__actions">

                            <button class="button button--red" type="button" ng-click="toggleCreate()">
                                <span class="button__icon fa fa-fw fa-times"></span>
                            </button>

                            <button class="button button--green" type="submit" ng-disabled="createForm.$invalid">
                                <span class="button__icon fa fa-fw fa-save"></span>
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /CREATE-CONTAINER -->

    <!-- UPDATE-CONTAINER -->
    <div class="overlay overlay--green" ng-class="{'is-active': toggler.update}">
        <div class="overlay__wrapper">
            <div class="overlay__content" ng-show="toggler.update">

                <div class="overlay__header">
                    <p><span class="fa fa-fw fa-pencil"></span> Neuen Eintrag erstellen</p>

                    <div class="overlay__hide">
                        <span class="fa fa-fw fa-eye-slash"></span>
                    </div>
                </div>

                <div class="overlay__body">

                    <form class="form" role="form" ng-submit="submitUpdate()">

                        <?php foreach ($crud->update as $k => $item): ?>
                            <div class="form__item form__inputgroup">
                                <label class="form__label"><?= $item['alias'] ?>:</label>
                                <?= $crud->createElement($item, $crud::TYPE_UPDATE); ?>
                                <div class="form__active"></div>
                            </div>
                        <?php endforeach; ?>

                        <div class="form__actions">

                            <button class="button button--red" type="button" ng-click="closeUpdate()">
                                <span class="button__icon fa fa-fw fa-times"></span>
                            </button>

                            <button class="button button--green" type="submit" ng-disabled="updateForm.$invalid">
                                <span class="button__icon fa fa-fw fa-save"></span>
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /UPDATE-CONTAINER -->

    <!-- STRAP-CONTAINER -->
    <div class="overlay overlay--green" ng-class="{'is-active': toggler.strap}">
        <div class="overlay__wrapper">
            <div class="overlay__content" ng-show="toggler.strap">
                <div class="overlay__body" ng-bind-html="data.strap.content"></div>
            </div>
        </div>
    </div>
    <!-- /STRAP-CONTAINER -->

</div>
