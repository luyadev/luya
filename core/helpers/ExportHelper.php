<?php

namespace luya\helpers;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecordInterface;
use luya\helpers\ArrayHelper;
use yii\helpers\Html;
use luya\Exception;

/**
 * Exporting into Formats.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ExportHelper
{
    /**
     *
     * @param unknown $input
     * @param array $keys
     * @param string $header
     * @return string
     */
    public static function csv($input, array $keys = [], $header = true)
    {
        if ($input instanceof ActiveQueryInterface) {
            $input = $input->all();
        }

        return self::generateContent($input, ',', $keys, $header);
    }

    /**
     *
     * @param array $contentRows
     * @param unknown $delimiter
     * @param unknown $keys
     * @param string $generateHeader
     * @return string
     */
    protected static function generateContent($contentRows, $delimiter, $keys, $generateHeader = true)
    {
        if (is_scalar($contentRows)) {
            throw new Exception("Content must be either an array, object or Travarsable");
        }
        
        $attributeKeys = $keys;
        $header = [];
        $rows = [];
        $i = 0;
        foreach ($contentRows as $content) {
            // handle rows content
            if (!empty($keys) && is_array($content)) {
                foreach ($content as $k => $v) {
                    if (!in_array($k, $keys)) {
                        unset($content[$k]);
                    }
                }
            } elseif (!empty($keys) && is_object($content)) {
                $attributeKeys[get_class($content)] = $keys;
            }
            $rows[$i] = ArrayHelper::toArray($content, $attributeKeys, false);
            
            // handler header
            if ($i == 0 && $generateHeader) {
                if ($content instanceof ActiveRecordInterface) {
                    foreach ($content as $k => $v) {
                        if (empty($keys)) {
                            $header[] = $content->getAttributeLabel($k);
                        } elseif (in_array($k, $keys)) {
                            $header[] = $content->getAttributeLabel($k);
                        }
                    }
                } else {
                    $header = array_keys($rows[0]);
                }
            }
            
            $i++;
        }

        $output = null;
        if ($generateHeader) {
            $output.= self::generateRow($header, $delimiter, '"');
        }
        foreach ($rows as $row) {
            $output.= self::generateRow($row, $delimiter, '"');
        }

        return $output;
    }

    /**
     *
     * @param array $row
     * @param unknown $delimiter
     * @param unknown $enclose
     * @return string
     */
    protected static function generateRow(array $row, $delimiter, $enclose)
    {
        array_walk($row, function (&$item) use ($enclose) {
            $item = $enclose.Html::encode($item).$enclose;
        });
        
        return implode($delimiter, $row) . PHP_EOL;
    }
}
