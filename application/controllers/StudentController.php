<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentController extends CI_Controller
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
        $this->load->library('upload', $this->config->item('upload_settings'));
    }

    public function addStudent()
    {
        $this->form_validation->set_rules('studentName','student Name','required');
        $this->form_validation->set_rules('dateOfBirth','date Of Birth','required');
        $this->form_validation->set_rules('institutionName','institution Name','required');
        $this->form_validation->set_rules('gender','Gender','required');
        $this->form_validation->set_rules('motherName','mother Name','required');
        $this->form_validation->set_rules('fatherName','father Name ','required');
        $this->form_validation->set_rules('aadharNumber','aadhar Number ','required');
        $this->form_validation->set_rules('nationality','nationality ','required');
        $this->form_validation->set_rules('mediumOfStudy','medium of study ','required');
        $this->form_validation->set_rules('qualification','qualification ','required');
        $this->form_validation->set_rules('subject','subject  ','required');
        $this->form_validation->set_rules('course','course','required');
        $this->form_validation->set_rules('subjectShortForm','subject short form ','required');
        $this->form_validation->set_rules('durationStart','duration start ','required');
        $this->form_validation->set_rules('durationEnd','duration End ','required');
        $this->form_validation->set_rules('contactNumber','contact Number ','required');
        $this->form_validation->set_rules('email','email ','required');
        $this->form_validation->set_rules('studentAddress','student Address ','required');
        //$this->form_validation->set_rules('photoPath','photo Path ','required');
        $this->form_validation->set_rules('updatedBy','updated by ','required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        if(!$this->upload->do_upload('Photo'))
        {
            echo json_encode(["error" => "Something went wrong. Photo was not uploaded properly."]);
            return ;
        }
        $photoData =$this->upload->data();
        $data=array(
            'student_name'=>$this->input->post('studentName'),
            'date_of_birth'=>$this->input->post('dateOfBirth'),
            'institution_name'=>$this->input->post('institutionName'),
            'gender'=>$this->input->post('gender'),
            'mother_name'=>$this->input->post('motherName'),
            'father_name'=>$this->input->post('fatherName'),
            'aadhar_number'=>$this->input->post('aadharNumber'),
            'nationality'=>$this->input->post('nationality'),
            'medium_of_study'=>$this->input->post('mediumOfStudy'),
            'qualification'=>$this->input->post('qualification'),
            'subject'=>$this->input->post('subject'),
            'course'=>$this->input->post('course'),
            'subject_short_form'=>$this->input->post('subjectShortForm'),
            'duration_start'=>$this->input->post('durationStart'),
            'duration_end'=>$this->input->post('durationEnd'),
            'contact_number'=>$this->input->post('contactNumber'),
            'email'=>$this->input->post('email'),
            'student_address'=>$this->input->post('studentAddress'),
            'file_name' => $photoData['file_name'],
            'photo_path' => $photoData['full_path'],
            'updated_by'=>$this->input->post('updatedBy'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        if($this->db->insert('student_info',$data))
        {
            $insert_id = $this->db->insert_id();
            $response = array(
                'status' => 'success',
                'message' => 'Student was added successfully',
                'student_id' => $insert_id
            );
        }else{
            $response = array(
                'status' => 'error',
                'message' => 'Failed to add student'
            );
        }
        echo json_encode($response);
    }
    /// edit student
    public function editStudent()
    {
        $this->form_validation->set_rules('id','student Id','required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $id=$this->input->post('id');
        if(!$this->StudentModel->checkStudentExists($id))
        {
            echo json_encode([
                'status' => false,
                'message' => "Studen ID is missing!"
                
            ]);
            return;
        }
        $update_data = array();
        if (isset($_POST['student_name'])) $update_data['student_name'] = $_POST['student_name'];
        if (isset($_POST['date_of_birth'])) $update_data['date_of_birth'] = $_POST['date_of_birth'];
        if (isset($_POST['institution_name'])) $update_data['institution_name'] = $_POST['institution_name'];
        if (isset($_POST['gender'])) $update_data['gender'] = $_POST['gender'];
        if (isset($_POST['motherName'])) $update_data['motherName'] = $_POST['motherName'];
        if (isset($_POST['father_name'])) $update_data['father_name'] = $_POST['father_name'];
        if (isset($_POST['aadhar_number'])) $update_data['aadhar_number'] = $_POST['aadhar_number'];
        if (isset($_POST['nationality'])) $update_data['nationality'] = $_POST['nationality'];
        if (isset($_POST['medium_of_study'])) $update_data['medium_of_study'] = $_POST['medium_of_study'];
        if (isset($_POST['qualification'])) $update_data['qualification'] = $_POST['qualification'];
        if (isset($_POST['subject'])) $update_data['subject'] = $_POST['subject'];
        if (isset($_POST['course'])) $update_data['course'] = $_POST['course'];
        if (isset($_POST['subject_short_form'])) $update_data['subject_short_form'] = $_POST['subject_short_form'];
        if (isset($_POST['duration_start'])) $update_data['duration_start'] = $_POST['duration_start'];
        if (isset($_POST['duration_end'])) $update_data['duration_end'] = $_POST['duration_end'];
        if (isset($_POST['duration_end'])) $update_data['duration_end'] = $_POST['duration_end'];
        if (isset($_POST['contact_number'])) $update_data['contact_number'] = $_POST['contact_number'];
        if (isset($_POST['email'])) $update_data['email'] = $_POST['email'];
        if (isset($_POST['student_address'])) $update_data['student_address'] = $_POST['student_address'];
        //$update_data['updated_at']=date('Y-m-d H:i:s'); 
        $this->db->where('id',$id);
        $k=$this->db->update('student_info',$update_data);
        if($k)
        {
            $response = array(
                'status' => 'success',
                'message' => 'Student updated successfully',
            );
            

        }else{
            $response =array(
                "status"=> "error",
                "message"=> "No valid data to update"
            );
        }
        echo json_encode($response);
    }

    //get all

    public function GetAllStudent()
    {
        $studen = $this->StudentModel->GetAllStudentModel();
        if(!$studen){
            echo json_encode([
                'status' => false,
                'message' => "no data found"
                
            ]);
            return;
        }
        $pagination = [
            "current_page" => 1,
            "per_page" => 10,
            "total" => count($studen),
            "last_page" => 1,
            "next_page_url" => null,
            "prev_page_url" => null
        ];
        $response = [
            "status" => "success",
            "meta" => [
                "code" => 200,
                "details" => "studen retrieved successfully",
                "timestamp" => date('c')
            ],
            "data" => [
                "pagination" => $pagination,
                "items" => $studen,
                "columns" => [
                    "id" => "ID",
                    "student_name" => "STUDENT NAME",
                    "date_of_birth" => "DATE_OF_BIRTH",
                    "institution_name" => "INSTITUTION NAME",
                    "gender" => "GENDER",
                    "mother_name" => "MOTHER_NAME",
                    "father_name" => "FATHER_NAME",
                    "aadhar_number" => "AADHAR_NUMBER",
                    "nationality" => "NATIONALITY",
                    "medium_of_study" => "MEDIUM_OF_STUDY",
                    "qualification" => "QUALIFICATION",
                    "subject" => "SUBJECT",
                    "course" => "COURSE",
                    "subject_short_form" => "SUBJECT_SHORT_FORM",
                    "duration_start" => "DURATION_START",
                    "duration_end" => "DURATION_END",
                    "contact_number"=>"CONTACT_NUMBER",
                    "email"=>"EMAIL",
                    "student_address"=>"STUDENT_ADDRESS",
                    "file_name"=>"FILE_NAME",
                    "photo_path"=>"PHOTO_PATH",
                    "updated_by"=>"UPDATED_BY",
                    "created_at" => "CREATED_AT",
                    "updated_at" => "UPDATED_AT"
                ]
            ]
        ];
        $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($response));

    }
    public function deleteStudent()
    {
        $this->form_validation->set_rules('studentId','student id','required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $studentId=$this->input->post('studentId');
        if(!$this->StudentModel->checkStudentExists($studentId))
        {
            echo json_encode([
                'status' => false,
                'message' => "Studen ID is missing!"
                
            ]);
            return;
        }
        if($this->db->where('id',$studentId)->delete('student_info'))
        {
            $response = array(
                'status' => 'success',
                'message' => 'Student deleted successfully',
            );

        }else{
            $response = array(
                'status' => 'error',
                'message' => 'Failed to deleted student'
            );
        }
        echo json_encode($response); 
    }
    

    
}
?>