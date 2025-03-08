<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_rights_db extends CI_Model{

    public function get_user_rights_db($user_id){

        $this->db->select('
        m.id , 
        m.menu_name ,
         m.priority , 
         m.parent_id ,
         m.type ,
         ur.user_id , 
         IFNULL(ur.add_rights , 0) as add_rights , 
         IFNULL(ur.delete_rights , 0) as delete_rights , 
         IFNULL(ur.update_rights , 0) as update_rights, 
         IFNULL(ur.view_rights , 0) as view_rights
         ');
        $this->db->from('menu_master m');
        $this->db->join('user_rights ur', 'm.id = ur.menu_id AND ur.user_id = ' . $this->db->escape($user_id), 'left');
        $result = $this->db->get();

        return $result;

    }

    public function set_user_rights_db($user_permission , $user_id , $table_name){

        $this->db->where('user_id' , $user_id);
        if($this->db->delete($table_name)){

            return $this->db->insert($table_name , $user_permission);

        }else{

            return 0;

        }


    }


}