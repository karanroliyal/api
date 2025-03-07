<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crud_db extends CI_Model{


    public function insert_data_db($table_name , $insert_data){

        return $this->db->insert($table_name , $insert_data);

    }

    public function update_data_db(){

        echo 'update';

    }

}