<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Date_model extends CI_Model
{
        /**
     * Normalize ANY common date format into Y-m-d
     * Handles:
     *  d/m/yy, d-m-yy
     *  d/m/yyyy, d-m-yyyy
     *  yyyy-m-d, yyyy/m/d
     *  yyyy-mm-dd
     */
    public function normalize_date($date)
    {
        if (empty($date)) {
            return null;
        }

        $date = trim($date);

        // Convert slashes to dashes
        $date = str_replace('/', '-', $date);

        // If format is like d-m-yy or d-m-yyyy
        if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{2}|\d{4})$/', $date, $m)) {

            $day   = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $month = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            $year  = $m[3];

            // Convert 2-digit year → 19xx or 20xx
            if (strlen($year) == 2) {
                $year = ($year >= 70) ? '19' . $year : '20' . $year;
            }

            return "$year-$month-$day";
        }

        // If format is yyyy-m-d or yyyy-mm-dd
        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $date, $m)) {

            $year  = $m[1];
            $month = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            $day   = str_pad($m[3], 2, '0', STR_PAD_LEFT);

            return "$year-$month-$day";
        }

        // Fallback to strtotime
        $timestamp = strtotime($date);

        if ($timestamp === false) {
            return null;
        }

        return date('Y-m-d', $timestamp);
    }

}