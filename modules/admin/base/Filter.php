<?php

namespace admin\base;

abstract class Filter
{
    const EFFECT_RESIZE = 'resize';

    const EFFECT_THUMBNAIL = 'thumbnail';

    const EFFECT_CROP = 'crop';

    abstract public function identifier();

    abstract public function name();

    abstract public function chain();

    public $log = [];

    public function getFilterId()
    {
        $data = \admin\models\StorageFilter::find()->where(['identifier' => $this->identifier()])->one();
        if ($data) {
            $data->scenario = 'restupdate';
            $data->name = $this->name();
            $data->update();
            return $data->id;
        } else {
            // insert new filter
            $model = new \admin\models\StorageFilter();
            $model->scenario = 'restcreate';
            $model->attributes = [
                'name' => $this->name(),
                'identifier' => $this->identifier(),
            ];
            if ($model->save()) {
                $this->log[] = "created a new filter '".$this->identifier()."'.";

                return $model->id;
            }
        }
    }

    private function resolveEffect($effectIdentifier)
    {
        $model = \admin\models\StorageEffect::find()->where(['identifier' => $effectIdentifier])->asArray()->one();
        if ($model) {
            return $model;
        }

        throw new \Exception("the provieded effect '$effectIdentifier' identifier does not exists in database.");
    }

    /**
     * create the output for the exec import script like you would insert the data from the admin view. (json response, find effect_id from the effect identifier).
     */
    public function getChain()
    {
        $data = [];
        foreach ($this->chain() as $row) {
            $effect = $this->resolveEffect($row[0]);

            $params = json_decode($effect['imagine_json_params'], true);

            foreach ($row[1] as $key => $value) {
                $notfound = true;
                foreach ($params['vars'] as $param) {
                    if ($param['var'] == $key) {
                        $notfound = false;
                    }
                }
            }

            if ($notfound) {
                throw new \Exception("the effect argument '$key' with value '$value' does not exists in the vars list of the effect '{$effect['name']}'");
            }

            $data[] = ['effect_id' => $effect['id'], 'effect_json_values' => json_encode($row[1])];
        }

        return $data;
    }

    public function save()
    {
        $filterId = $this->getFilterId();

        $processed = [];

        foreach ($this->getChain() as $chain) {
            $model = \admin\models\StorageFilterChain::find()->where(['filter_id' => $filterId, 'effect_id' => $chain['effect_id']])->one();
            if ($model) {
                $model->effect_json_values = $chain['effect_json_values'];
                if ($model->save()) {
                    $this->log[] = "updated existing chain value for $filterId.";
                    $processed[] = $model->id;
                }
            } else {
                $insert = new \admin\models\StorageFilterChain();
                $insert->attributes = [
                    'filter_id' => $filterId, 'effect_id' => $chain['effect_id'], 'effect_json_values' => $chain['effect_json_values'],
                ];
                if ($insert->save()) {
                    $this->log[] = "insert new chain value for $filterId and {$chain['effect_id']}.";
                    $processed[] = $insert->id;
                }
            }
        }

        $where = [];
        foreach ($processed as $id) {
            $where[] = 'id <> '.$id;
        }

        // find old effects
        $data = \admin\models\StorageFilterChain::find()->where('('.implode(' AND ', $where).') AND filter_id='.$filterId)->all();
        foreach ($data as $deletion) {
            $this->log[] = "deleted old chain value {$deletion->id}.";
            $deletion->delete();
        }

        return $this->log;
    }
}
