<?php

namespace luya\admin\base;

use luya\admin\models\StorageFilter;
use luya\admin\models\StorageEffect;
use luya\admin\models\StorageFilterChain;
use luya\Exception;
use yii\helpers\Json;
use yii\base\BaseObject;

/**
 * Base class for all storage component filters.
 *
 * The available effects for the chain are stored in the database, here the default effects which are
 * provided when installing luya:
 *
 * + thumbnail: width, height, mode, saveOptions
 * + crop: width, height, saveOptions
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Filter extends BaseObject implements FilterInterface
{
    /**
     * Resize-Effect.
     */
    //const EFFECT_RESIZE = 'resize';

    const THUMBNAIL_MODE_INSET = 'inset';
    
    const THUMBNAIL_MODE_OUTBOUND = 'outbound';
    
    /**
     * Thumbnail-Effect.
     */
    const EFFECT_THUMBNAIL = 'thumbnail';

    /**
     * Crop-Effect.
     */
    const EFFECT_CROP = 'crop';

    /**
     * Understandable Name expression for the effect.
     *
     * @return string A string containing the name to be listed in the admin area.
     */
    abstract public function name();

    /**
     * An array with represents the chain effects and the value of the defined effects.
     *
     * @return array Example response for chain() method:
     *
     * ```php
     * return [
     *     [self::EFFECT_THUMBNAIL, [
     *         'width' => 100,
     *         'height' => 100,
     *     ]],
     * ];
     * ```
     */
    abstract public function chain();

    /**
     * @var array An array containing all log messages
     */
    public $log = [];

    /**
     * @var mixed|array Private property to store the effect params list
     */
    private $_effectParamsList;

    /**
     * Add message to log array.
     *
     * @param string $message The message to log
     */
    public function addLog($message)
    {
        $this->log[] = $message;
    }

    /**
     * Return the log array.
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
     * @return object \luya\admin\models\StorageFilter
     */
    public function findModel()
    {
        // find filter model based on the identifier
        $model = StorageFilter::find()->where(['identifier' => static::identifier()])->one();
        // if no model exists, create new record
        if (!$model) {
            $model = new StorageFilter();
            $model->setAttributes([
                'name' => $this->name(),
                'identifier' => static::identifier(),
            ]);
            $model->insert(false);
            $this->addLog("added new filter '".static::identifier()."' to database.");
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
     * @throws \luya\Exception
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
     * Get an array with all the effect param options, based on the effect params defintion.
     *
     * @param array $effectParams
     * @throws \luya\Exception When the vars key does not exists in the effect definition.
     * @return array
     */
    public function getEffectParamsList($effectParams)
    {
        if ($this->_effectParamsList === null) {
            // see if the the effect defintion contains a vars key
            if (!array_key_exists('vars', $effectParams)) {
                throw new Exception("Required 'vars' key not found in effect definition array.");
            }

            foreach ($effectParams['vars'] as $item) {
                $this->_effectParamsList[] = $item['var'];
            }
        }

        return $this->_effectParamsList;
    }

    /**
     * Returns a parsed effect chain for the current Filter. The method verifys if the provieded effect
     * parameters are available in the effect defintions of luya.
     *
     * @return array Each row of the array must have "effect_id" and "effect_json_values" key.
     * @throws \luya\Exception When effect option could be found in the effect defintions.
     */
    public function getChain()
    {
        $data = [];
        // get the chain from the effect, must be an array
        foreach ($this->chain() as $chainRow) {
            // set variables from chain array
            $effectIdentifier = $chainRow[0];
            $effectParams = $chainRow[1];
            // find the effect data for the effect identifier
            $effect = $this->findEffect($effectIdentifier);
            // get all params from the effect chain and verify if they are valid
            foreach ($effectParams as $effectParamVar => $effectParamValue) {
                if (!in_array($effectParamVar, $this->getEffectParamsList(Json::decode($effect['imagine_json_params'])))) {
                    throw new Exception("Effect argument '$effectParamVar' does not exist in the effect definition of '{$effect['name']}'.");
                }
            }
            // create array with parsed effect id
            $data[] = ['effect_id' => $effect['id'], 'effect_json_values' => Json::encode($effectParams)];
        }

        return $data;
    }

    /**
     * Update and save filter corresponding to the model, refresh chain values.
     *
     * @return bool
     */
    public function save()
    {
        // get the filter model based on the current filter.
        $filterModel = $this->findModel();
        // update the name of the filter if changed
        if ($filterModel->name !== $this->name()) {
            $filterModel->setAttribute('name', $this->name());
            $filterModel->update(false);
            $this->addLog("Filter name '".$this->name()."' have been updated for identifier '".static::identifier()."'.");
        }
        // array containing the processed chain ids
        $processed = [];

        $removeImages = false;
        
        foreach ($this->getChain() as $chain) {
            // get filter chain for filter and effect
            $model = StorageFilterChain::find()->where(['filter_id' => $filterModel->id, 'effect_id' => $chain['effect_id']])->one();
            if ($model) {
                if (md5($chain['effect_json_values']) != md5(Json::encode($model->effect_json_values))) {
                    $model->effect_json_values = $chain['effect_json_values'];
                    if ($model->update(false)) {
                        $removeImages = true;
                        $this->addLog("[!] {$filterModel->name}: effect chain has changed.");
                    }
                }
            } else {
                $model = new StorageFilterChain();
                $model->setAttributes(['filter_id' => $filterModel->id, 'effect_id' => $chain['effect_id'], 'effect_json_values' => $chain['effect_json_values']]);
                if ($model->save(false)) {
                    $removeImages = true;
                    $this->addLog("[+] {$filterModel->name}: Effect chain option/s have been added.");
                }
            }
            $processed[] = $model->id;
        }
        // remove not used chains for the current filter
        foreach (StorageFilterChain::find()->where(['not in', 'id', $processed])->andWhere(['=', 'filter_id', $filterModel->id])->all() as $deletion) {
            $this->addLog("[-] {$filterModel->name}: Effect chain option/s have been removed.");
            $deletion->delete();
            $removeImages = true;
        }
        
        if ($removeImages) {
            $this->addLog("[!] {$filterModel->name}: Remove images.");
            $removeLog = $filterModel->removeImageSources();
            foreach ($removeLog as $id => $sucess) {
                if ($sucess) {
                    $this->addLog('✓ image ' . $id . ' sucessfull unlinked.');
                } else {
                    $this->addLog('⨯ error while unlinking image id ' . $id);
                }
            }
        }

        return true;
    }
}
