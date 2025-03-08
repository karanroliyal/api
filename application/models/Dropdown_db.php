<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dropdown_db extends CI_Model{

    public function get_list_db($table_name , $fields_name){

        $this->db->select($fields_name);
        return $this->db->get($table_name);

    }

}