<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;// ** (Excel sheet)
class StudentResultController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StudentModel');
        $this->load->library('form_validation');
        $this->form_validation = $this->form_validation;
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->helper('url');
        header('Content-Type: application/json');
        
    }
        public function addStudentResults()
        {
            $this->form_validation->set_rules('StudentName', 'Student Name', 'required');
            $this->form_validation->set_rules('EnrollmentNumber', 'Enrollment Number', 'required');
            $this->form_validation->set_rules('CourseName', 'Course Name', 'required');
            $this->form_validation->set_rules('Marks', 'Marks', 'required');
            $this->form_validation->set_rules('Grade', 'Grade', 'required');
        // $this->form_validation->set_rules('institution_id', 'Institution ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                echo json_encode([
                    'status' => false,
                    'message' => validation_errors()
                ]);
                return;
            }

            $data = array(
                'student_name'       => $this->input->post('StudentName'),
                'enrollment_number'  => $this->input->post('EnrollmentNumber'),
                'course_name'        => $this->input->post('CourseName'),
                'marks'              => $this->input->post('Marks'),
                'grade'              => $this->input->post('Grade')
            );

            if ($this->db->insert('student_results', $data)) {
                $response = [
                    'status'  => 'success',
                    'message' => 'Student result added successfully'
                ];
            } else {
                $response = [
                    'status'  => 'error',
                    'message' => 'Student result not added'
                ];
            }

            echo json_encode($response);
        }

        public function importStudentResults()
        {
            if (empty($_FILES['file']['name'])) {
                $response = array('status' => 'error', 'message' => 'No file selected.');
                echo json_encode($response);
                return;
            }
            if (!is_dir('./uploads/import/')) {
                mkdir('./uploads/import/', 0777, true);
            }
            $config['upload_path']   = './uploads/import/'; 
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size']      = 2048; // 2MB max
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $response = array('status' => 'error', 'message' => $this->upload->display_errors());
                echo json_encode($response);
                return;
            }
            // Get uploaded file path
            $fileData = $this->upload->data();
            $filePath = $fileData['full_path'];
            // Load PhpSpreadsheet
            $spreadsheet = IOFactory::load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
           
            // Remove the first row (header)    
            array_shift($sheetData);
                // Insert data into the database
            foreach ($sheetData as $row) {
                $data = array(
                    'student_name'  => $row[0],
                    'enrollment_number'=> $row[1],
                    'course_name'     => $row[2],
                    'marks'       => $row[3],
                    'grade'       => $row[4]
                );
                $this->db->insert('student_results', $data);
            }
            $response = array('status' => 'success', 'message' => 'Excel data imported successfully.');
            echo json_encode($response);
        }

}
?>