<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CSV Import Library
 * Parses CSV files into an associative array
 */
class Csvimport 
{
    /**
     * Parse CSV file into an array
     * 
     * @param string $filename Path to the CSV file
     * @return array|false Returns array of rows or false on error
     */
    public function get_array($filename)
    {
        // Validate file exists and is readable
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        // Validate file extension
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($ext !== 'csv') {
            return false;
        }

        $array = array();
        $headers = array();
        $row_count = 0;

        if (($handle = fopen($filename, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $row_count++;

                // First row is headers
                if ($row_count === 1) {
                    $headers = $data;
                    // Validate that headers are not empty
                    if (empty(array_filter($headers))) {
                        fclose($handle);
                        return false;
                    }
                    continue;
                }

                // Skip empty rows
                if (empty(array_filter($data))) {
                    continue;
                }

                // Create associative array using headers as keys
                $row = array();
                foreach ($headers as $index => $header) {
                    $header = trim($header);
                    // Use the header name (trimmed) or the index if header is empty
                    $key = !empty($header) ? $header : $index;
                    $value = isset($data[$index]) ? trim($data[$index]) : '';
                    $row[$key] = $value;
                }

                $array[] = $row;
            }
            fclose($handle);
        } else {
            return false;
        }

        // Return false if no data rows were found (only headers or empty file)
        if (empty($array)) {
            return false;
        }

        return $array;
    }
}
/* End of file Csvimport.php */
/* Location: ./application/libraries/Csvimport.php */
