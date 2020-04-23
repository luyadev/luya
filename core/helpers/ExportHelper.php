<?php

namespace luya\helpers;

use luya\Exception;
use yii\base\Model;
use yii\db\QueryInterface;

/**
 * Exporting into Formats.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ExportHelper
{
    /**
     * Export an Array or QueryInterface instance into a CSV formated string.
     *
     * @param array|QueryInterface $input The data to export into a csv
     * @param array $keys Defines which keys should be packed into the generated CSV. The defined keys does not change the sort behavior of the generated csv.
     * @param string $header Whether the column name should be set as header inside the csv or not.
     * @return string The generated CSV as string.
     */
    public static function csv($input, array $keys = [], $header = true)
    {
        $delimiter = ",";
        $input = self::transformInput($input);
        $array = self::generateContentArray($input, $keys, $header);

        return self::generateOutputString($array, $delimiter);
    }

    /**
     * Export an Array or QueryInterface instance into a Excel formatted string.
     *
     * @param array|QueryInterface $input
     * @param array $keys Defines which keys should be packed into the generated xlsx. The defined keys does not change the sort behavior of the generated xls.
     * @param bool $header
     * @return mixed
     * @throws Exception
     * @since 1.0.4
     */
    public static function xlsx($input, array $keys = [], $header = true)
    {
        $input = self::transformInput($input);

        $array = self::generateContentArray($input, $keys, $header);

        $writer = new XLSXWriter();
        $writer->writeSheet($array);

        return $writer->writeToString();
    }

    /**
     * Check type of input and return correct array.
     *
     * @param array|QueryInterface $input
     * @return array
     * @since 1.0.4
     */
    protected static function transformInput($input)
    {
        if ($input instanceof QueryInterface) {
            return $input->all();
        }

        return $input;
    }

    /**
     * Generate content by rows.
     *
     * @param array $contentRows
     * @param string $delimiter
     * @param array $keys
     * @param bool $generateHeader
     * @return array
     * @throws Exception
     * @since 1.0.4
     */
    protected static function generateContentArray($contentRows, array $keys, $generateHeader = true)
    {
        if (is_scalar($contentRows)) {
            throw new Exception("Content must be either an array, object or traversable.");
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
            $row = ArrayHelper::toArray($content, $attributeKeys, false);
            ksort($row);
            $rows[$i] = $row;

            // handle header
            if ($i == 0 && $generateHeader) {
                if ($content instanceof Model) {
                    /** @var Model $content */
                    foreach ($content as $k => $v) {
                        if (empty($keys)) {
                            $header[$k] = $content->getAttributeLabel($k);
                        } elseif (in_array($k, $keys)) {
                            $header[$k] = $content->getAttributeLabel($k);
                        }
                    }
                } else {
                    $header = array_keys($rows[0]);
                }

                ksort($header);
            }

            unset($row);
            gc_collect_cycles();
            $i++;
        }

        if ($generateHeader) {
            return ArrayHelper::merge([$header], $rows);
        }

        return $rows;
    }

    /**
     * Generate the output string with delimiters.
     *
     * @param array $input
     * @param string $delimiter
     * @return null|string
     * @since 1.0.4
     */
    protected static function generateOutputString(array $input, $delimiter)
    {
        $output = null;
        foreach ($input as $row) {
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
     * @since 1.0.4
     */
    protected static function generateRow(array $row, $delimiter, $enclose)
    {
        array_walk($row, function (&$item) use ($enclose) {
            if (is_bool($item)) {
                $item = (int) $item;
            } elseif (is_null($item)) {
                $item = '';
            } elseif (!is_scalar($item)) {
                $item = "[array]";
            }
            $item = $enclose.str_replace([
                '"',
            ], [
                '""',
            ], $item).$enclose;
        });

        return implode($delimiter, $row) . PHP_EOL;
    }
}
