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
        $this->load->library('upload');
        
    }

    public function UploadHallTicket(){

        $this->form_validation->set_rules('EnrollmentNumber','Student Enrollment Number','required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }

        $uploadPath = './uploads/HallTicket/';
        if (!is_dir($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
        }
        $config['upload_path']   = $uploadPath;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 2048; // Max file size 2MB
        $this->upload->initialize($config);
        
        $EnrollmentNumber=$this->input->post('EnrollmentNumber');
        if($this->upload->do_upload('HallTicket'))
        {
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

    public function MultipleUploadHallTicket(){
        $uploadPath = './uploads/HallTicket/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $config['upload_path']   = $uploadPath;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 2048;
        $this->upload->initialize($config);

      
        $files = $_FILES;
        $file_count = isset($_FILES['files']['name']) && is_array($_FILES['files']['name']) ? count($_FILES['files']['name']) : 0;
        

        if ($file_count === 0) {
            echo json_encode(['status' => 'error', 'message' => 'No files selected.']);
            return;
        }
        $uploaded_files = [];
        for ($i = 0; $i < $file_count; $i++)
        {
            $_FILES['file']['name']     = $files['files']['name'][$i];
            $_FILES['file']['type']     = $files['files']['type'][$i];
            $_FILES['file']['tmp_name'] = $files['files']['tmp_name'][$i];
            $_FILES['file']['error']    = $files['files']['error'][$i];
            $_FILES['file']['size']     = $files['files']['size'][$i];

            if($this->upload->do_upload('file')){
                $fileData = $this->upload->data();
                $fileName = pathinfo($fileData['file_name'], PATHINFO_FILENAME);
                $filePath = base_url('uploads/HallTicket/' . $fileData['file_name']); 

                 // Save file info to database
                 $this->HallTicketModel->MultipleUploadHallTicket($fileName, $filePath);
                 $uploaded_files[] = [
                    'file_name' => $fileName,
                    'file_path' => $filePath
                 ];
            }
        }
        if (empty($uploaded_files)) {
            echo json_encode(['status' => 'error', 'message' => 'No files uploaded.']);
        } else {
            echo json_encode(['status' => 'success', 'files' => $uploaded_files]);
        }
    }

    
}
?>