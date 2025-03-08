<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('login_db');
    }

    public function login_verification()
    {
        $log_data = $_POST;

        $_POST = $this->fx->remove_unwanted_data($_POST);

        $result = $this->login_db->check_login_details_db($_POST);

        if (!empty($result)) {

            $jwtToken = $this->jwt_token->generate_token($result);

            // $this->fx->user_log_creator($log_data['action'] , $_POST , $log_data['table_name'] , $result->id , 'login');

            echo $this->fx->api_response(200 ,  $jwtToken , 'Login successfully');

        } else {

            echo $this->fx->api_response(400 ,  'Login' , 'failed');

        }

    }


}
