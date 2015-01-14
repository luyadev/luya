<?php
namespace admin\apis;

use luya\Luya;

class MenuController extends \admin\base\RestVerbController
{
    public function actionIndex()
    {
        $menu = array();

        $i = 1;
        foreach (luya::getParams('adminMenus') as $id => $item) {
            $x = $item;
            $x['id'] = $i;

            $menu[$i] = $x;
            $i++;
        }

        return $menu;
    }

    public function actionView()
    {
        $getId = $_GET['id'];

        /* DUMB ASS CODE! */
        $menu = array();
        $i = 1;
        foreach (luya::getParams('adminMenus') as $id => $item) {
            $menu[$i] = $item;
            $i++;
        }

        /* END OF DUMB ASS CODE ! */

        return $menu[$getId];
    }
}
