<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_db extends CI_Model{

    public function check_login_details_db($login_details){

        $this->db->where($login_details);

        return $this->db->get('user_master')->row();


    }

    
}