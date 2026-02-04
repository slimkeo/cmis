<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enum_model extends CI_Model {

    public function get_enum_values($table, $field)
    {
        $query = $this->db->query("SHOW COLUMNS FROM `$table` LIKE '$field'");
        $row = $query->row();

        if (!$row) {
            return [];
        }

        preg_match("/^enum\((.*)\)$/", $row->Type, $matches);
        $enum = explode(",", str_replace("'", "", $matches[1]));

        return $enum;
    }
}
