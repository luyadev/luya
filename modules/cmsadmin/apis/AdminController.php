<?php
namespace cmsadmin\apis;

/**
 * api-cms-admin
 * 
 * Basic admin rest jobs
 * 
 * @author nadar
 * 
 */
class AdminController extends \admin\base\RestController
{
    public function actionGetAllBlocks()
    {
        $data = [];
        foreach (\cmsadmin\models\Block::find()->all() as $item) {
            $object = \cmsadmin\models\Block::objectId($item['id']);
            $data[] = [
                'id' => $item['id'],
                'name' => $object->getName()
            ];
        }
        
        return $data;
    }
}