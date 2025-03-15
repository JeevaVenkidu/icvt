<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatesController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('StatesModel');

        $this->load->library('form_validation'); 
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->helper('url');
        header('Content-Type: application/json');
        
    }
    
    public function getAllStates(){
        $states= $this->StatesModel->getAllStates();
        if($states){
            echo json_encode([
                'status' => true,
                'message' => 'States retrieved successfully',
                'data' => $states
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'No states found'
            ]);
        }
    }


     
       
}
?>