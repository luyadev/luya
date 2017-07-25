<?php

namespace luya\helpers;

/**
 * Import from Formats to Array.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ImportHelper
{
    /**
     * Import a CSV from a string or filename and return array.
     *
     * @param string $filename Can be either a filename which is parsed by {{luya\helpers\FileHelper::getFileContent}} or a string with the contained csv data.
     * @param array $options Provide options to the csv
     * + removeHeader: boolean, Whether the import csv contains a header in the first row to skip or not. Defaults to false
     * + delimiter: string, The delimiter
     * + fields: array, An array with fielnames (based on the array header if any, or position) which should be parsed into the final export.
     * ```php
     * 'fields' => ['firstname', 'lastname'] // will only parse those fields based on table header (row 0)
     * 'fields' => [0,1,3] // will only parse fields by those positions if no table header is present. Positions starts at 0
     * ```
     * @return Returns an array with the csv data.
     */
    public static function csv($filename, array $options = [])
    {
        // check if a given file name is provided or a csv based on the content
        if (FileHelper::getFileInfo($filename)->extension) {
            $input = FileHelper::getFileContent($filename);
        } else {
            $input = $filename;
        }
        // http://php.net/manual/de/function.str-getcsv.php#101888
        $data = str_getcsv($input, "\n");
        foreach ($data as &$row) {
            $row = str_getcsv($row, ArrayHelper::getValue($options, 'delimiter', ','));
        }
        
        // check whether only an amount of fields should be parsed into the final array
        $fields = ArrayHelper::getValue($options, 'fields', false);
        if ($fields && is_array($fields)) {
            $filteredData = [];
            foreach ($fields as $fieldColumn) {
                if (!is_numeric($fieldColumn)) {
                    $fieldColumn = array_search($fieldColumn, $data[0]);
                }
                foreach ($data as $key => $rowValue) {
                    if (array_key_exists($fieldColumn, $rowValue)) {
                        $filteredData[$key][] = $rowValue[$fieldColumn];
                    }
                }
            }

            $data = $filteredData;
            unset($filteredData);
        }
        
        // if the option to remove a header is provide. remove the first key and reset and array keys
        if (ArrayHelper::getValue($options, 'removeHeader', false)) {
            unset($data[0]);
            $data = array_values($data);
        }
        
        return $data;
    }
}
