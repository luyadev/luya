<?php

namespace luya\admin\components;

/**
 * Interface of the AdminMenuBuilder class.
 *
 * If the AdminMenuBuilder class is instance of the AdminMenuBuilderInterface we can ensure to get the menu data with `menu()` method.
 *
 * @since 1.0.0
 * @author Basil Suter <basil@nadar.io>
 */
interface AdminMenuBuilderInterface
{
    /**
     * Get the Menu Array.
     *
     * Example Response:
     *
     * ```php
     * Array (
     * [moduleId] => admin
     * [template] =>
     * [routing] => default
     * [alias] => menu_node_system
     * [icon] => layers
     * [permissionRoute] =>
     * [permissionIsRoute] =>
     * [searchModelClass] =>
     * [groups] => Array (
     *        [menu_group_access] => Array  (
     *               [name] => menu_group_access
     *               [items] => Array  (
     *                       [0] => Array (
     *                               [alias] => menu_access_item_user
     *                               [route] => admin/user/index
     *                               [icon] => person
     *                               [permssionApiEndpoint] => api-admin-user
     *                               [permissionIsRoute] =>
     *                               [permissionIsApi] => 1
     *                               [searchModelClass] =>
     *                               [options] => Array ()
     *                           )
     *                       [1] => Array  (
     *                               [alias] => menu_access_item_group
     *                               [route] => admin/group/index
     *                               [icon] => group
     *                               [permssionApiEndpoint] => api-admin-group
     *                               [permissionIsRoute] =>
     *                               [permissionIsApi] => 1
     *                               [searchModelClass] =>
     *                               [options] => Array ( )
     *                           )
     *                   )
     *           )
     * )
     * ```
     *
     * @return array The menu array with all its nodes, subnodes routes and apis.
     */
    public function menu();
    
    public function getPermissionApis();
    
    public function getPermissionRoutes();
}
