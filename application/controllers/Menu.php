<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_db');
    }

    public function get_menu(){

        $login_user_data = $this->jwt_token->get_verified_token();

       $result =  $this->menu_db->get_menu_db( $login_user_data->id );

       echo json_encode($result);

    }


}