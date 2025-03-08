<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crud_db extends CI_Model
{


    public function insert_data_db($table_name, $insert_data)
    {

        return $this->db->insert($table_name, $insert_data);
    }

    public function update_data_db($table_name, $updated_data, $id_on_update_perform)
    {

        $this->db->where('id', $id_on_update_perform);
        return $this->db->update($table_name, $updated_data);
    }

    public function get_edit_data_db($edit_id, $table_name)
    {

        $this->db->where('id', $edit_id);
        return $this->db->get($table_name);
    }

    public function delete_data_db($delete_id, $table_name)
    {

        $this->db->where('id', $delete_id);
        $this->db->delete($table_name);
        return $this->db->affected_rows();
    }

    public function get_table_db($table_name, $limit, $current_page, $sortOn, $sortOrder, $fields, $searchFields)
    {

       
    }
}
