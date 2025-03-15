<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AffiliationController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AffiliationModel');
        $this->load->library('form_validation'); 
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->helper('url');
        header('Content-Type: application/json');
        $this->load->library('upload', $this->config->item('upload_settings'));
        
    }
    
    public function AddAffiliation()
    { 
        $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('city', 'City', 'required|trim');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'required|numeric');
        $this->form_validation->set_rules('website', 'Website', 'valid_url');
        $this->form_validation->set_rules('sector', 'Sector', 'required|trim');
        $this->form_validation->set_rules('institution_name', 'Institution Name', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('postal_address', 'Postal Address', 'required');
        $this->form_validation->set_rules('state', 'State', 'required|trim');
        $this->form_validation->set_rules('selected_courses', 'Selected Courses', 'required');
        //$this->form_validation->set_rules('status', 'Status', 'required|in_list[Pending,Approved,Rejected]');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }

        $data = array(
            'applicant_name'     => $this->input->post('applicant_name'),
            'phone_number'       => $this->input->post('phone_number'),
            'city'               => $this->input->post('city'),
            'postal_code'        => $this->input->post('postal_code'),
            'website'            => $this->input->post('website'),
            'sector'             => $this->input->post('sector'),
            'institution_name'   => $this->input->post('institution_name'),
            'mobile_number'      => $this->input->post('mobile_number'),
            'permanent_address'  => $this->input->post('permanent_address'),
            'email'              => $this->input->post('email'),
            'postal_address'     => $this->input->post('postal_address'),
            'state'              => $this->input->post('state'),
            'selected_courses'   => $this->input->post('selected_courses'), // Comma-separated course IDs
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s')
        );
        $this->db->insert('affiliation', $data);
        $affiliation_id = $this->db->insert_id(); // Get the last inserted ID
        $count=0;
        //profileImage
        if ($this->upload->do_upload('profileImage')) {
            $profileUpload = $this->upload->data(); // Store uploaded file details
            $profileUploadStatus=$this->AffiliationModel->AddAffiliation($profileUpload,$affiliation_id);
            if(!$profileUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Profile image was not uploaded properly."]);
                
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }

        //InstitutionRegistration
        if ($this->upload->do_upload('InstitutionRegistration')) {
            $InstitutionRegistrationUpload = $this->upload->data(); // Store uploaded file details
            $InstitutionRegistrationUploadStatus=$this->AffiliationModel->AddAffiliation($InstitutionRegistrationUpload,$affiliation_id);
            if(!$InstitutionRegistrationUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Institution Registration file was not uploaded properly."]);
              
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }
        //BuildingRegistration
        if ($this->upload->do_upload('BuildingRegistration')) {
            $BuildingRegistrationUpload = $this->upload->data(); // Store uploaded file details
            $BuildingRegistrationUploadStatus=$this->AffiliationModel->AddAffiliation($BuildingRegistrationUpload ,$affiliation_id);
            if(!$BuildingRegistrationUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Building Registration file was not uploaded properly."]);
                
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }

        //IDProof

        if ($this->upload->do_upload('IDProof')) {
            $IDProofUpload = $this->upload->data(); // Store uploaded file details
            $IDProofUploadUploadStatus=$this->AffiliationModel->AddAffiliation($IDProofUpload ,$affiliation_id);
            if(!$IDProofUploadUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. ID Proof file was not uploaded properly."]);
               
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }
        
       //FrontOfficePhoto

        if ($this->upload->do_upload('FrontOfficePhoto')) {
            $FrontOfficePhotoUpload = $this->upload->data(); // Store uploaded file details
            $FrontOfficePhotoUploadStatus=$this->AffiliationModel->AddAffiliation($FrontOfficePhotoUpload ,$affiliation_id);
            if(!$FrontOfficePhotoUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Front Office Photo was not uploaded properly."]);
               
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }

        //ClassroomPhoto

        if ($this->upload->do_upload('ClassroomPhoto')) {
            $ClassroomPhotoUpload = $this->upload->data(); // Store uploaded file details
            $ClassroomPhotoUploadStatus=$this->AffiliationModel->AddAffiliation($ClassroomPhotoUpload ,$affiliation_id);
            if(!$ClassroomPhotoUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Classroom Photo was not uploaded properly."]);
                
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }
        //NameBoard

        if ($this->upload->do_upload('NameBoard')) {
            $NameBoardUpload = $this->upload->data(); // Store uploaded file details
            $NameBoardUploadStatus=$this->AffiliationModel->AddAffiliation($NameBoardUpload ,$affiliation_id);
            if(!$NameBoardUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Name Board Photo was not uploaded properly."]);
              
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }
        //LabPhoto
        if ($this->upload->do_upload('LabPhoto')) {
            $LabPhotoUpload = $this->upload->data(); // Store uploaded file details
            $LabPhotoUploadStatus=$this->AffiliationModel->AddAffiliation($LabPhotoUpload ,$affiliation_id);
            if(!$LabPhotoUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Lab Photo was not uploaded properly."]);
                
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }

        //OwnerPhoto

        if ($this->upload->do_upload('OwnerPhoto')) {
            $OwnerPhotoUpload = $this->upload->data(); // Store uploaded file details
            $OwnerPhotoUploadStatus=$this->AffiliationModel->AddAffiliation($OwnerPhotoUpload ,$affiliation_id);
            if(!$OwnerPhotoUploadStatus)
            {
                echo json_encode(["error" => "Something went wrong. Lab Photo was not uploaded properly."]);
               
            }else{
                $count++;
            }
        } else {
            echo $this->upload->display_errors(); // Show error if upload fails
        }
        
        if ($affiliation_id) {
            if($count==9){
                echo json_encode([
                    'status' => true,
                    'message' => 'Affiliation added successfully',
                    'affiliation_id' => $affiliation_id
                ]);

            }else{
                echo json_encode([
                    'status' => true,
                    'message' => 'Affiliation added successfully but some files are missing try to reuplode it',
                    'affiliation_id' => $affiliation_id
                ]);

            }
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Failed to add affiliation'
            ]);
        }

    }


    //get
    public function LoadAffiliationInstituion()
    {
        $id = $this->input->get('id', TRUE);
        if (!empty($id)){
            $Instituion = $this->AffiliationModel->GetInstituion($id);
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
            $Instituion = $this->AffiliationModel->GetAllInstituion();
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


    public function DeleteAffiliation()
    {   $this->form_validation->set_rules('affiliationid', 'affiliationid', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $affiliationId = $this->input->post('affiliationid', TRUE);
        $checkAffiliationExists=$this->AffiliationModel->checkAffiliationExists($affiliationId);
        if (!$checkAffiliationExists) {
            echo "User ID is missing!";
            return;
        }
        if($this->db->where('affiliation_id', $affiliationId)->delete('uploads')){
            
            if ($this->db->where('id', $affiliationId)->delete('affiliation'))
            {
                echo json_encode([
                    "status" => true,
                    "message" => "Affiliation and associated uploads deleted successfully."
                ]);
            }else{
                echo json_encode([
                    "status" => false,
                    "message" => "Failed to delete affiliation."
                ]);
            }
        }else{
            echo json_encode([
                "status" => false,
                "message" => "Failed to delete affiliation uplodes."
            ]);

        }
    }      
    public function EditStatus()
    {
        $this->form_validation->set_rules('id', 'id', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
                
            ]);
            return;
        }
        $id=$this->input->post('id');
        
        $data=array(
            'status'=>$status=$this->input->post('status'),
            'updated_at'=> date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        $this->db->update('affiliation', $data);
        if ($this->db->affected_rows() > 0) {
            echo "Record updated successfully!";
        } else {
            echo "No changes made or invalid ID.";
        }
    }

    public function editAffiliation(){
        $this->form_validation->set_rules('id','Affiliation Id','required');
        if($this->form_validation->run() == FALSE){
            echo json_encode([
                'status'=>false,
                'message'=>validation_errors()
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
        if($this->AffiliationModel->updateAffiliation($update_data,$_POST['id'])){
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
}
?>