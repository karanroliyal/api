<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dropdown extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('dropdown_db');
    }

    public function get_dropdown(){

        $table_name = $_POST['table_name'];
        $action = $_POST['action'];
        
        $_POST = $this->fx->remove_unwanted_data($_POST);

        $result = $this->dropdown_db->get_list_db($table_name , $_POST['fields']);


        if($result != null){

            echo $this->fx->api_response(200 , $result->result_array()  , 'Get list successfully');
            return;
        }else{

            echo $this->fx->api_response(400 , $result , 'Unable to get list');
            return;
        }

    }

}