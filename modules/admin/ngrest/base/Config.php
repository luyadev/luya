<?php

namespace admin\ngrest\base;

/**
 * @todo what about extrafields?
 * @todo getNgRestConfig method in module to link between 
 *
 * @author nadar
 */
abstract class Config extends \yii\base\Object
{
    public function getList()
    {
        return [
            ['title', 'Titel', 'text'],
            ['alias', 'Alias Name', 'date'],
            ['selection', 'BlablaAuswahl', 'checkboxrelation', ['foo', 'bar', '123', '3']],
        ];
    }

    public function getCreate()
    {
        // and so on
    }

    public function getUpdate()
    {
        // and so on   
    }

    public function getDelete()
    {
        // and so on
    }
}
