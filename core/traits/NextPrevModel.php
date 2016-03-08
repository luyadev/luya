<?php

namespace luya\traits;

/**
 * Trait to us within ActiveRecords to get next and prev (previous) model records of the current
 * ActiveRecord object model.
 * 
 * @author nadar
 * @since 1.0.0-beta6
 */
trait NextPrevModel
{
    public function getNext()
    {
        return self::find()->where(['>', 'id', $this->id])->limit(1)->one();
    }
    
    public function getPrev()
    {
        return self::find()->where(['<', 'id', $this->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
    }
}