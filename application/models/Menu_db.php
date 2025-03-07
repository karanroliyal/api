<?php

class Menu_db extends CI_Model{

    public function get_menu_db($login_user_id){

        $this->db->select('
        
        mm.id,
        mm.menu_name,
        mm.icon,
        mm.priority,
        mm.menu_url,
        mm.parent_id
        
        ');
        $this->db->from('menu_master mm');
        $this->db->join('user_rights ur' , 'ur.menu_id = mm.id');
        $this->db->where('ur.user_id' , $login_user_id);
        return $this->db->get('')->result_array();

    }


}