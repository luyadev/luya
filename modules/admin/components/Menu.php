<?php
namespace admin\components;

/**
 * following code:.
 *
 * $menu = new Menu();
 * $node = $menu->createNode('admin', 'Administrator', 'fa-bullet');
 * $group = $menu->createGroup($node, 'Verwalten', [
 *     $menu->createItem('user', 'Benutzer', 'admin:user:index', 'fa-account'),
 *     $menu->createItem('group', 'Gruppen', 'admin:group:index', 'fa-groups')
 * ]);
 *
 * produces an config array like:
 *
 * [
 *      'admin' => [
 *          'alias' => 'Administrator',
 *          'id' => 'admin',
 'icon' => 'fa-bullet',
 // Gruppe 1
 'groups' => [
 [
 'name' => 'Verwalten',
 'items' => [
 'user' => [
 'id' => 'user',
 'alias' => 'Benutzer',
 'route' => 'admin:user:index',
 'icon' => 'fa-account'
 ],
 'group' => [
 'id' => 'group',
 'alias' => 'Gruppen',
 'route' => 'admin:group:index',
 'icon' => 'fa-groups'
 ]
 ]
 ]
 ]
 ]
 ]
 *
 *
 * @author nadar
 */
class Menu
{
    public $menu = [];

    public function createNode($id, $alias, $icon, $template = false)
    {
        $this->menu[$id] = [
            'id' => $id,
            'alias' => $alias,
            'icon' => $icon,
            'template' => $template,
            'routing' => $template ? 'custom' : 'default',
            'groups' => [],
        ];

        return $id;
    }

    public function createGroup($nodeId, $groupAlias, $items)
    {
        $this->menu[$nodeId]['groups'][] = [
            'name' => $groupAlias,
            'items' => $items,
        ];
    }

    public function createItem($id, $alias, $route, $icon)
    {
        return [
            'id' => $id,
            'alias' => $alias,
            'route' => $route,
            'icon' => $icon,
        ];
    }

    public function get()
    {
        return $this->menu;
    }
}
