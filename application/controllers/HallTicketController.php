<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class HallTicketController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('HallTicketModel');
        $this->load->library('form_validation'); 
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->helper('url');
        header('Content-Type: application/json');
        $this->load->library('upload', $this->config->item('upload_settings'));
        
    }
    public function UploadHallTicket(){
        $this->form_validation->set_rules('EnrollmentNumber','Enrollment Number', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'status' => 'Error',
                'message' => validation_errors()
                
            ]);
            return;
        }
        $EnrollmentNumber=$this->input->post('EnrollmentNumber');
        if($this->upload->do_upload('HallTicket')){
            $HallTicketUplodeData=$this->upload->data();
            if($this->HallTicketModel->UploadHallTicketModel($EnrollmentNumber,$HallTicketUplodeData))
            {
                $response = [
                    'status'  => 'success',
                    'message' => 'HallTicket Upload  successfully'
                ];
            }else{
                $response = [
                    'status'  => 'error',
                    'message' => 'HallTicket not Upload'
                ];
            }
            echo json_encode($response);

        }

       
    }

    
}
?>