<?php

class Menu_db extends CI_Model{

    // Give menu arrocding to login user id
    public function get_menu_db($login_user_id)
    {
        // echo $login_user_id;die;
        $this->db->select('
        mm.id,
        mm.menu_name,
        mm.icon,
        mm.priority,
        mm.menu_url,
        mm.parent_id,
        mm.type
        ');
        $this->db->from('menu_master mm');
        $this->db->join('user_rights ur', 'ur.menu_id = mm.id');
        $this->db->where('ur.user_id', $login_user_id);
        $this->db->order_by('mm.priority', 'ASC'); // Order by priority

        return  $this->db->get();
    }

    
}
