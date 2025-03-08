<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crud extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('crud_db');
        $this->load->library('form_validation');
        $this->config->load('form_validation', TRUE); // Load validation rules
    }

    public function insert_update_operation()
    {

        $table_name = $_POST['table_name'];
        $action = $_POST['action'];

        $_POST = $this->fx->remove_unwanted_data($_POST);

        $rules = $this->config->item($table_name, 'form_validation');

        if (!$rules) {
            echo $this->fx->api_response(400, 'error', 'Validation rules not found!');
            return;
        }

        $this->form_validation->set_rules($rules);


        if ($this->form_validation->run()) {

            if ($action == 'insert') {

                $_POST['create_by'] = $this->CI->jwt_token->get_verified_token()->id();

                $result = $this->crud_db->insert_data_db($table_name, $_POST);

                if ($result == 1) {

                    echo $this->fx->api_response(200, $result, "Data inserted successfully on table $table_name");
                    return;
                } else {

                    echo $this->fx->api_response(400, $result, "Unable to insert data on table $table_name");
                    return;
                }
            } else if ($action == 'update') {

                $_POST['modify_by'] = $this->jwt_token->get_verified_token()->id;

                $id_on_update_perform = $_POST['id'];
                unset($_POST['id']);
                if (empty(trim($_POST['password']))) {
                    unset($_POST['password']);
                }

                $result = $this->crud_db->update_data_db($table_name, $_POST, $id_on_update_perform);

                if ($result == 1) {
                    echo $this->fx->api_response(200, $result, "Data updated successfully on table $table_name");
                    return;
                } else {
                    echo $this->fx->api_response(400, $result, "Unable to update data on table $table_name");
                    return;
                }
            }
        } else {

            echo $this->fx->api_response(400, $this->form_validation->error_array(), 'Please enter valid data');
            return;
        }
    }

    public function get_edit_data()
    {

        $table_name = $_POST['table_name'];
        $action = $_POST['action'];
        $edit_id = $_POST['id'];

        $result = $this->crud_db->get_edit_data_db($edit_id, $table_name);

        if ($result->num_rows() > 0) {

            $this->fx->user_log_creator($action, $_POST, $table_name, $edit_id, $action);
            echo $this->fx->api_response(200, $result->row(), 'Data get successfully');
            return;
        } else {

            echo $this->fx->api_response(400, 'null', 'Unable to get data');
            return;
        }
    }

    public function delete_data()
    {

        $table_name = $_POST['table_name'];
        $action = $_POST['action'];
        $delete_id = $_POST['id'];

        $result = $this->crud_db->delete_data_db($delete_id, $table_name);


        if ($result != 0) {
            $this->fx->user_log_creator($action, $_POST, $table_name, $delete_id, $action);
            echo $this->fx->api_response(200, $result, 'Record deleted successfully');
            return;
        } else {
            echo $this->fx->api_response(400, $result, 'Unable to delete data');
            return;
        }
    }

    public function table_creator(){

        echo 'table function';die;
        $action =  $_POST['action'];
        $table_name   = $_POST['table_name'];
        $limit        = $_POST['limit'] ?: 5;
        $current_page = $_POST['current_page'] ?: 1;
        $sortOn       = $_POST['sortOn'] ?: 'id';
        $sortOrder    = $_POST['sortOrder'] ?: 'DESC';
        $fileds = $_POST['fields']; // fields name for select statement

        unset($_POST['action']);
        unset($_POST['table_name']);
        unset($_POST['limit']);
        unset($_POST['current_page']);
        unset($_POST['sortOn']);
        unset($_POST['sortOrder']);
        unset($_POST['fields']);


        // Call model function
        $result = $this->crud_db->get_table_db(
            $table_name, $limit, $current_page, $sortOn, $sortOrder, $fileds , $_POST
        );

        // Send JSON response
        echo json_encode($result);

    }


}
