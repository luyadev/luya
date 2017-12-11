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
     * Export an Array or ActiveQuery instance into a CSV formated string.
     *
     * @param array|ActiveQueryInterface $input The data to export into a csv
     * @param array $keys Defines which keys should be packed into the generated CSV. The defined keys does not change the sort behavior of the generated csv.
     * @param string $header Whether the column name should be set as header inside the csv or not.
     * @return string The generated CSV as string.
     */
    public static function csv($input, array $keys = [], $header = true)
    {
        if ($input instanceof ActiveQueryInterface) {
            $input = $input->all();
        }

        return self::generateContent($input, ',', $keys, $header);
    }

    /**
     * Generate content by rows.
     *
     * @param array $contentRows
     * @param string $delimiter
     * @param string $keys
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
     * Generate a row by its items.
     *
     * @param array $row
     * @param string $delimiter
     * @param string $enclose
     * @return string
     */
    protected static function generateRow(array $row, $delimiter, $enclose)
    {
        array_walk($row, function (&$item) use ($enclose) {
            if (!is_scalar($item)) {
                $item = "array";
            }
            $item = $enclose.Html::encode($item).$enclose;
        });
        
        return implode($delimiter, $row) . PHP_EOL;
    }
}
