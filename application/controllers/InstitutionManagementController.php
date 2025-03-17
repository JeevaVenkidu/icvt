<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InstitutionManagementController extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('InstitutionManagementModel');
        $this->load->library('form_validation'); 
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->helper('url');
        header('Content-Type: application/json');
        $this->load->library('upload', $this->config->item('upload_settings'));
        
    }

    public function addInstitution()
    {
        $this->form_validation->set_rules('InstitutionName','Institution Name','required');
        $this->form_validation->set_rules('courses','courses','required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $data = array(
            'institution_name'   => $this->input->post('InstitutionName'),
            'status'              => '',
            'selected_courses'   => $this->input->post('courses'), // Comma-separated course IDs
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s')
        );
        $this->db->insert('affiliation', $data);
        $affiliation_id = $this->db->insert_id();
        if($affiliation_id){
            echo json_encode([
                'status' => true,
                'message' => 'Institution added successfully',
                'Institution_id' => $affiliation_id
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'Failed to add Institution'
            ]);
        }

    }


    public function LoadInstitution()
    {
        $id = $this->input->get('id', TRUE);
        if (!empty($id)){
            $Instituion = $this->InstitutionManagementModel->GetInstitution($id);
            if(empty($Instituion))
            {
                echo "no data found";
                return ;
            }
            $pagination = [
                "current_page" => 1,
                "per_page" => 10,
                "total" => count($Instituion),
                "last_page" => 1,
                "next_page_url" => null,
                "prev_page_url" => null
            ];
            $response = [
                "status" => "success",
                "meta" => [
                    "code" => 200,
                    "details" => "Instituion retrieved successfully",
                    "timestamp" => date('c')
                ],
                "data" => [
                    "pagination" => $pagination,
                    "items" => $Instituion,
                    "columns" => [
                        "id" => "ID",
                        "applicant_name" => "APPLICANT_NAME",
                        "phone_number" => "PHONE_NUMBER",
                        "city" => "CITY",
                        "postal_code" => "POSTAL_CODE",
                        "website" => "WEBSITE",
                        "sector" => "SECTOR",
                        "institution_name" => "INSTITUTION_NAME",
                        "mobile_number" => "MOBILE_NUMBER",
                        "permanent_address" => "PERMANENT_ADDRESS",
                        "email" => "EMAIL",
                        "postal_address" => "POSTAL_ADDRESS",
                        "state" => "STATE",
                        "selected_courses" => "SELECTED_COURSES",
                        "created_at" => "CREATED_AT",
                        "updated_at" => "UPDATED_AT",
                        "status" => "STATUS"
                    ]
                ]
            ];
            $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
        }else{
            $Instituion = $this->InstitutionManagementModel->GetAllInstitution();
            if(empty($Instituion))
            {
                echo "no data found";
                return ;
            }

            $pagination = [
                "current_page" => 1,
                "per_page" => 10,
                "total" => count($Instituion),
                "last_page" => 1,
                "next_page_url" => null,
                "prev_page_url" => null
            ];
            $response = [
                "status" => "success",
                "meta" => [
                    "code" => 200,
                    "details" => "Instituion retrieved successfully",
                    "timestamp" => date('c')
                ],
                "data" => [
                    "pagination" => $pagination,
                    "items" => $Instituion,
                    "columns" => [
                        "id" => "ID",
                        "applicant_name" => "APPLICANT_NAME",
                        "phone_number" => "PHONE_NUMBER",
                        "city" => "CITY",
                        "postal_code" => "POSTAL_CODE",
                        "website" => "WEBSITE",
                        "sector" => "SECTOR",
                        "institution_name" => "INSTITUTION_NAME",
                        "mobile_number" => "MOBILE_NUMBER",
                        "permanent_address" => "PERMANENT_ADDRESS",
                        "email" => "EMAIL",
                        "postal_address" => "POSTAL_ADDRESS",
                        "state" => "STATE",
                        "selected_courses" => "SELECTED_COURSES",
                        "created_at" => "CREATED_AT",
                        "updated_at" => "UPDATED_AT",
                        "status" => "STATUS"
                    ]
                ]
            ];
            $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));

        }
    }
    public function editInstitution(){
        $this->form_validation->set_rules('InstituionId','Instituion Id','required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $id=$this->input->post('InstituionId');
        if(!$this->InstitutionManagementModel->checkInstitutionExists($id))
        {
            echo json_encode([
                'status' => false,
                'message' => "Instituion ID is missing!"
                
            ]);
            return;
        }
        $update_data=array();
        if(isset($_POST['applicant_name']))$update_data['applicant_name']=$_POST['applicant_name'];
        if(isset($_POST['phone_number']))$update_data['phone_number']=$_POST['phone_number'];
        if(isset($_POST['city']))$update_data['city']=$_POST['city'];
        if(isset($_POST['postal_code']))$update_data['postal_code']=$_POST['postal_code'];
        if(isset($_POST['website']))$update_data['website']=$_POST['website'];
        if(isset($_POST['sector']))$update_data['sector']=$_POST['sector'];
        if(isset($_POST['institution_name']))$update_data['institution_name']=$_POST['institution_name'];
        if(isset($_POST['mobile_number']))$update_data['mobile_number']=$_POST['mobile_number'];
        if(isset($_POST['permanent_address']))$update_data['permanent_address']=$_POST['permanent_address'];
        if(isset($_POST['email']))$update_data['email']=$_POST['email'];
        if(isset($_POST['postal_address']))$update_data['postal_address']=$_POST['postal_address'];
        if(isset($_POST['state']))$update_data['state']=$_POST['state'];
        if(isset($_POST['selected_courses']))$update_data['selected_courses']=$_POST['selected_courses'];
        $update_data['updated_at']=date('Y-m-d H:i:s');

        if($this->InstitutionManagementModel->updateInstitution($update_data,$id)){
            $response = array(
                'status' => 'success',
                'message' => 'Institution updated successfully',
            );

        }else{
            $response =array(
                "status"=> "error",
                "message"=> "Institution not updated  "
            );

        }
        echo json_encode($response);
    }

    public function deleteInstitution(){
        $this->form_validation->set_rules('InstituionId','Instituion Id','required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $id=$this->input->post('InstituionId');
        if(!$this->InstitutionManagementModel->checkInstitutionExists($id))
        {
            echo json_encode([
                'status' => false,
                'message' => "Instituion ID is missing!"
                
            ]);
            return;
        }
        if($this->InstitutionManagementModel->deleteInstitutionModel($id)){
            echo json_encode([
                'status' => "success",
                'message' => "Instituion deleted successfully"
                
            ]);
        }else{
            echo json_encode([
                'status' => "error",
                'message' => "Instituion not deleted"
                
            ]);

        }
    }





}

?>