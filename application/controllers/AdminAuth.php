<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAuth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AdminAuthModel');
        $this->load->library('form_validation');
        $this->load->helper('url');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Content-Type: application/json');
    }

   /* public function AddAdmin()
    {
        $username='Admin';
        $password='Admin@123';
        if(!$this->AdminAuthModel->AddAdminModel($username,$password))
        {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add admin']);
            return;
        }
        echo json_encode(['status' => 'success', 'message' => 'Admin added successfully']);
    }*/

    public function AdminLogin()
    {
        $this->form_validation->set_rules('username','username','required');
        $this->form_validation->set_rules('password','password','required');
        if($this->form_validation->run() == FALSE){
            echo json_encode([
                'status'=>false,
                'message'=>validation_errors()
            ]);
            return;
        }
        $userName=$this->input->post('username',true);
        $passWord=$this->input->post('password',true);
        if(!$this->AdminAuthModel->AdminLoginModel($userName,$passWord))
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
            return;
        }
        echo json_encode(['status' => 'success', 'message' => 'Login successful', 'admin' => $userName]);
    }
}

?>