<?php
namespace admin\straps;

class FilterEffectChain extends \admin\ngrest\StrapAbstract
{
    public function render()
    {
        return $this->getView()->render("@admin/views/strap/FilterEffectChain", [
            'effectModel' => new \admin\models\StorageEffect(),
        ]);
    }

    public function callbackAddEffect($effectId, $effectArguments)
    {
        $model = new \admin\models\StorageFilterChain();

        $model->setAttributes([
            "filter_id" => $this->getItemId(),
            "effect_id" => $effectId,
            "effect_json_values" => $effectArguments,
        ]);

        if ($model->save()) {
            return $this->response(true, []);
        }

        return $this->response(false, $model->getErrors());
    }

    public function callbackLoadEffects()
    {
        $data = \admin\models\StorageFilterChain::find()->where(['filter_id' => $this->getItemId()])->all();
        $view = $this->getView()->render('@admin/views/strap/FilterEffectChainList', [
            "data" => $data,
        ]);

        return $this->response(true, ['html' => $view]);
    }
}
