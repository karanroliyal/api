<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_rights extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_rights_db');
    }

    public function get_user_rights()
    {

        $table_name = $_POST['table_name'];
        $action = $_POST['action'];

        $result = $this->user_rights_db->get_user_rights_db($_POST['id']);

        if ($result != null) {
            echo $this->fx->api_response(200, $result->result_array(), 'User rights get successfully');
        } else {
            echo $this->fx->api_response(400, $result, 'Unable to get user rights');
        }
    }


    public function set_user_rights()
    {

        $table_name = $_POST['table_name'];
        $action = $_POST['action'];

        $_POST = $this->fx->remove_unwanted_data($_POST);

        $result = $this->user_rights_db->set_user_rights_db($_POST, $_POST['user_id'], $table_name);

        if($result == 1){
            $this->fx->user_log_creator($action, $_POST , $table_name , $_POST['user_id'] , $table_name);
            $this->fx->api_response(200 , $result , 'User rights set successfully');
        }else{
            $this->fx->api_response(400 , $result , 'Unable to set rights');
        }

    }


}
