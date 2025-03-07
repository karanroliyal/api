<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Fx{

    protected $CI;

    public function __construct(){

        $this->CI = &get_instance();
        $this->CI->load->library('Jwt_token');
        $this->user_log_creator($_POST['action'] , $_POST , $_POST['table_name'] , 0 , 'login');
        if($this->CI->uri->segment(2) !== 'login_verification'){
            $this->CI->jwt_token->get_verified_token();
        };
        
    }

    public function remove_unwanted_data($request_data){

        unset($request_data['table_name']);
        unset($request_data['action']);

        return $request_data;

    }

    // to response 
    public function api_response($statusCode , $data ,  $message){

        if($statusCode == 200){
            return json_encode(['statusCode'=>$statusCode , 'status'=>true , 'data'=>$data , 'message'=>$message]);
        }else if($statusCode == 400){
            return json_encode(['statusCode'=>$statusCode , 'status'=>false , 'data'=> $data , 'message'=>$message]);
        }

    }

    // For creating user log in database to see user action 
    public function user_log_creator($action, $data , $action_table , $action_id , $menu_name )
    {

        $user_data = $this->CI->jwt_token->get_verified_token();
        $user_id = $user_data->id;
        $user_name = $user_data->user_name;
        $data = json_encode($data);
        $message = '';

        if ($action == 'insert') {
            $message = "$user_name (id : $user_id) inserted  id ($action_id) on $action_table table";
        } else if ($action == 'update') {
            $message = "$user_name (id : $user_id) updated id ($action_id) on $action_table table";
        } else if ($action == 'delete') {
            $message = "$user_name (id : $user_id) deleted id ($action_id) on $action_table table";
        }else if($action == 'call'){
            $message = "$user_name (id : $user_id) called this api : {$_SERVER['PHP_SELF']} on $action_table table";
        }else if($action == 'login'){
            $message = "$user_name (id : $user_id) has login";
        }else if($action == 'get menu'){
            $message = "$user_name (id : $user_id) has get menu";
        }


        $insert_data = [
            'menu_name' => $menu_name,
            'user_id' => $user_id,
            'action_perform' => $action,
            'data' => $data,
            'table_name' => $action_table,
            'message' => $message,
            'create_by'=>$user_id
        ];

        $this->CI->db->insert('user_log', $insert_data);

    }


}