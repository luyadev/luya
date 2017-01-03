<?php

namespace cmstests\src\menu;

use Yii;
use cmstests\CmsFrontendTestCase;

class QueryTest extends CmsFrontendTestCase
{
    public function testContainerSelector()
    {
        Yii::$app->composition['langShortCode'] = 'fr';
        Yii::$app->menu->setLanguageContainer('fr', include('_dataFrArray.php'));
        
        $containers = ['footer-column-one', 'footer-column-two', 'footer-column-three'];
        
        foreach ($containers as $container) {
            foreach (Yii::$app->menu->find()->where(['container' => $container])->all() as $item) {
                $link = $item->link;
                
                if (is_null($link)) {
                    $this->assertNull($link); // internal self redirect
                } else {
                    $this->assertNotEmpty($link);
                }
            }
        }
    }
}
