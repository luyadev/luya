<?php

namespace admin\base;

use Exception;
use admin\models\StorageFilter;
use admin\models\StorageEffect;
use admin\models\StorageFilterChain;

/**
 * Base class for all Filters
 * @author nadar
 */
abstract class Filter extends \yii\base\Object
{
    /**
     * @var string Resize-Effect
     */
    const EFFECT_RESIZE = 'resize';

    /**
     * @var string Thumbnail-Effect
     */
    const EFFECT_THUMBNAIL = 'thumbnail';

    /**
     * @var string Crop-Effect
     */
    const EFFECT_CROP = 'crop';

    abstract public function identifier();

    abstract public function name();

    abstract public function chain();

    /**
     * @var array An array containing all log messages
     */
    public $log = [];
    
    /**
     * Add message to log array
     *
     * @param string $message The message to log
     * @return void
     */
    public function addLog($message)
    {
        $this->log[] = $message;
    }
    
    /**
     * Return the log array
     *
     * @return array Array with log messages.
     */
    public function getLog()
    {
        return $this->log;
    }
    
    /**
     * Find the model based on the identifier. If the identifier does not exists in the database, create
     * new record in the database.
     * 
     * @return \admin\models\StorageFilter
     */
    public function findModel()
    {
        // find filter model based on the identifier
        $model = StorageFilter::find()->where(['identifier' => $this->identifier()])->one();
        // if no model exists, create new record
        if (!$model) {
            $model = new StorageFilter();
            $model->setAttributes([
                'name' => $this->name(),
                'identifier' => $this->identifier(),
            ]);
            $model->save(false);
            $this->addLog("added new filter '".$this->identifier()."' to database.");
        }
        
        return $model;
    }
    
    /**
     * Find the effect model based on the effect identifier. If the effect could not found an exception will
     * be thrown.
     * 
     * @param string $effectIdentifier The name of effect, used EFFECT prefixed constants like
     * + EFFECT_RESIZE
     * + EFFECT_THUMBNAIL
     * + EFFECT_CROP
     * @return array Contain an array with the effect properties.
     * @throws Exception 
     */
    public function findEffect($effectIdentifier)
    {
        // find effect model based on the effectIdentifier
        $model = StorageEffect::find()->where(['identifier' => $effectIdentifier])->asArray()->one();
        // if the effect model could not found, throw Exception.
        if (!$model) {
            throw new Exception("The requested effect '$effectIdentifier' does not exist.");
        }
        // array
        return $model;
    }
    
    /**
     * create the output for the exec import script like you would insert the data from the admin view. (json response, find effect_id from the effect identifier).
     * 
     * @todo cleanup & doc
     */
    public function getChain()
    {
        $data = [];
        foreach ($this->chain() as $row) {
            $effect = $this->findEffect($row[0]);

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
                throw new Exception("the effect argument '$key' with value '$value' does not exists in the vars list of the effect '{$effect['name']}'");
            }

            $data[] = ['effect_id' => $effect['id'], 'effect_json_values' => json_encode($row[1])];
        }

        return $data;
    }

    /**
     * @todo cleanup & doc
     */
    public function save()
    {
        $model = $this->findModel();
        
        // update the name of the filter if changed
        if ($model->name !== $this->name()) {
            $model->setAttribute('name', $this->name());
            $model->update(false);
            $this->addLog("Filter name '".$this->name()."' have been updated for identifier '".$this->identifier()."'.");
        }
        
        $filterId = $model->id;

        $processed = [];

        foreach ($this->getChain() as $chain) {
            $model = StorageFilterChain::find()->where(['filter_id' => $filterId, 'effect_id' => $chain['effect_id']])->one();
            if ($model) {
                $model->effect_json_values = $chain['effect_json_values'];
                if ($model->save()) {
                    $this->log[] = "updated existing chain value for $filterId.";
                    $processed[] = $model->id;
                }
            } else {
                $insert = new StorageFilterChain();
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
        // @todo use where("not in", "id", $where)
        $data = StorageFilterChain::find()->where('('.implode(' AND ', $where).') AND filter_id='.$filterId)->all();
        foreach ($data as $deletion) {
            $this->log[] = "deleted old chain value {$deletion->id}.";
            $deletion->delete();
        }

        return $this->log;
    }
}
