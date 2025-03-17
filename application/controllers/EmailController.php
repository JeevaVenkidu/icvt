<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('EmailModel');
        $this->load->library('form_validation'); 
        $this->load->library('email');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->helper('url');
        header('Content-Type: application/json');
    }

    public function sendEmailSubmit() {
        $this->form_validation->set_rules('id', ' Id', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $id=$this->input->post('id');
        if(!$this->EmailModel->checkIdExists($id)){
            echo json_encode([
                'status' => 'error',
                'message' => 'ID not found in the database.'
            ]);
            return;
        }
        $EmailId=$this->EmailModel->getEmail($id);
        if(!$EmailId){
            echo json_encode([
                'status' => 'error',
                'message' => 'Email not found in the database.'
            ]);
            return;
        }
        // Set email details
        $this->email->from('jeeva6316a@gmail.com', 'Jeeva'); // from
        $this->email->to($EmailId);//to
        $this->email->subject('Welcome to ICVTE - Document Verification in Process');
        $this->email->message($this->EmailModel->EmailMessage());

        // Send email and return response
        if ($this->email->send()) {
            echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->email->print_debugger()]);
        }
    }
    public function sendEmailApprove()
    {
        $this->form_validation->set_rules('id', ' Id', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $id=$this->input->post('id');
        if(!$this->EmailModel->checkIdExists($id)){
            echo json_encode([
                'status' => 'error',
                'message' => 'ID not found in the database.'
            ]);
            return;
        }
        if(!$this->EmailModel->checkApprovedStatus($id)){
            echo json_encode([
                'status' => 'error',
                'message' => 'Your application is not approved'
            ]);
            return;
        }
        $EmailId=$this->EmailModel->getEmail($id);
        $password=$this->EmailModel->getPassword($id);
        if(!$EmailId){
            echo json_encode([
                'status' => 'error',
                'message' => 'Email not found in the database.'
            ]);
            return;
        }
        $this->email->from('jeeva6316a@gmail.com', 'Jeeva'); // from
        $this->email->to($EmailId);//to
        $this->email->subject('Welcome to ICVTE - Document Verification in Process');
        $this->email->message($this->EmailModel->EmailMessageApprovedStatus($EmailId,$password));

        // Send email and return response
        if ($this->email->send()) {
            echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->email->print_debugger($EmailId,$password)]);
        }


    }

    
}
?>
