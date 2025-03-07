<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crud extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('crud_db');
        $this->load->library('form_validation');
    }

    public function create_operation(){

        $table_name = $_POST['table_name'];
        $action = $_POST['action'];

        print_r($_POST);die;

        $_POST = $this->fx->remove_unwanted_data($_POST);

        $rules = $this->config->item($table_name, 'form_validation');

        if (!$rules) {
            echo json_encode(['status' => 'error', 'message' => 'Validation rules not found!']);
            return;
        }

        $this->form_validation->set_rules($rules);


        if ($this->form_validation->run()) {

            if($action == 'insert' ){

                $result = $this->Crud_db->insert_data_db($table_name, $_POST);

                if($result){

                    echo $this->fx->api_response(200 , $result , "Data inserted successfully on table $table_name");

                }else{

                    echo $this->fx->api_response(400 , $result , "Data inserted successfully on table $table_name");

                }

            }else if($action == 'update'){

                if(empty(trim($_POST['password']))){
                    unset($_POST['password']);
                }
                $id_on_update_perform = $_POST['id']; 

                $this->Crud_db->update_data_db($table_name, $_POST , $id_on_update_perform);

            }
            
        } else {

            echo $this->fx->api_response(400 , $this->form_validation->error_array() , 'Please enter valid data' );

        }



        

    }

}