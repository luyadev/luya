<?php

namespace admin\traits;

trait SoftDeleteTrait 
{
    public static function SoftDeleteValues()
    {
        return [
            'is_deleted' => 1
        ];
    }
    
    public static function find()
    {
        $query = [];
        foreach(static::SoftDeleteValues() as $k => $v) {
            $query[$k] = !$v;
        }
        return parent::find()->where($query);
    }
    
    public function delete()
    {
        foreach(static::SoftDeleteValues() as $k => $v) {
            $this->$k = $v;
        }
        $this->update(false);
        return true;
    }
}