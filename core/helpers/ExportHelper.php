<?php

namespace app\helpers;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecordInterface;
use luya\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Exporting into other Formats.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class ExportHelper
{
    /**
     *
     * @param unknown $input
     * @return unknown
     */
    public static function csv($input, array $properties = [])
    {
        if ($input instanceof ActiveQueryInterface) {
            $input = $input->all();
        }

        return self::generateContent($input, ',', $properties);
    }

    /**
     * 
     * @param array $contentRows
     * @param unknown $delimiter
     * @param unknown $properties
     * @param string $generateHeader
     * @return NULL|string
     */
    protected static function generateContent(array $contentRows, $delimiter, $properties, $generateHeader = true)
    {
        $header = [];
        $rows = [];
        $i = 0;
        foreach ($contentRows as $key => $content) {
            // handler header
            if ($i == 0) {
                if ($content instanceof ActiveRecordInterface) {
                    $header[] = $content->getAttributeLabel($key);
                } else {
                    $header[] = $key;
                }
            }

            $rows[] = ArrayHelper::toArray($content, $properties, false);
            // handle content rows
            $i++;
        }

        $html = null;
        foreach ($rows as $row) {
            array_walk($row, function(&$item) {
                $item = '"'.Html::encode($item).'"';
            });

            $html.= implode($delimiter, $row) . PHP_EOL;
        }

        return $html;
    }
}