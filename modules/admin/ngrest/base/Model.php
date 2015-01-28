<?php

namespace admin\ngrest\base;

abstract class Model extends \yii\db\ActiveRecord
{
    public $ngRestEndpoint = null;

    public $ngRestPrimaryKey = null;

    public function getNgRestApiEndpoint()
    {
        return $this->ngRestEndpoint;
    }

    public function getNgRestPrimaryKey()
    {
        if (!empty($this->ngRestPrimaryKey)) {
            return $this->ngRestPrimaryKey;
        }

        return $this->getTableSchema()->primaryKey[0];
    }

    abstract public function ngRestConfig($config);

    public function getNgRestConfig()
    {
        $config = new \admin\ngrest\Config($this->getNgRestApiEndpoint(), $this->getNgRestPrimaryKey());

        return $this->ngRestConfig($config);
    }
}
