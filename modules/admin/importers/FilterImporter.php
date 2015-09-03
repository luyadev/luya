<?php

namespace admin\importers;

class FilterImporter extends \luya\base\Importer
{
    public function run()
    {
        $this->getImporter()->addLog('filters', 'start filters importer');
        foreach ($this->getImporter()->getDirectoryFiles('filters') as $file) {
            $filterClassName = $file['ns'];
            if (class_exists($filterClassName)) {
                $object = new $filterClassName();
                $this->getImporter()->addLog('filters', implode(', ', $object->save()));
            }
        }
    }
}
