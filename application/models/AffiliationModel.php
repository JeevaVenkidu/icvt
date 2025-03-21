<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AffiliationModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function addAffiliation($data,$affiliation_id){
        $profileArray = [
            'affiliation_id' => $affiliation_id,
            'file_name' => $data['file_name'], // Corrected from $data['File_name']
          
            'file_extension' => $data['file_ext'] ?? '', 
            'file_path' => $data['full_path'], // Corrected from $data['File_path']
            'uploaded_at' => date('Y-m-d H:i:s')
        ];
    
        return $this->db->insert('uploads', $profileArray);
    }

    public function GetInstituion($id){
        $query = $this->db->get_where('affiliation', ['id' => $id]); 
        return $query->row_array(); // Return single record as array
    }
    public function GetAllInstituion()
    {
        $query = $this->db->get('affiliation'); 
        return $query->result_array(); 
    }

    public function checkAffiliationExists($id)
    {
    $query = $this->db->get_where('affiliation', ['id' => $id]);
    return $query->num_rows() > 0; // Returns TRUE if ID exists, FALSE otherwise
    }
    public function updateAffiliation($update_data,$id){
        return $this->db->where('id', $id)->update('affiliation', $update_data) && $this->db->affected_rows() > 0;
    }
    public function getSelectedSectorIdModel($id) {
        $this->db->select('sector');
        $this->db->from('affiliation');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return explode(',', $row->selected_courses);
        }
        return [];
    }
    public function getSelectedSector($courseIds)
    {
        if (empty($courseIds)) {
            return [];
        }
        $query = $this->db->select('sector_name')
                          ->where_in('id', $courseIds) // Ensures multiple IDs are filtered
                          ->get('Sector'); // Directly fetch from the table

        return array_column($query->result_array(), 'sector_name');
    }

    public function UploadDeletion($affiliationId)
    {
        $k = 0;
        $this->db->select('file_path');
        $this->db->from('uploads');
        $this->db->where('affiliation_id', $affiliationId);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $file_path = $row->file_path;
                if (file_exists($file_path)) {
                    if (unlink($file_path)) {
                        $k = 1;
                    }
                }
            }
            $this->db->where('affiliation_id', $affiliationId);
            $this->db->delete('uploads');
        }
    
        return $k;
    }

    public function AffiliationUplodesExists($id)
    {
        $query = $this->db->get_where('uploads', ['id' => $id]);
        return $query->num_rows() > 0; // Returns TRUE if ID exists, FALSE otherwise
    }
    public function AffiliationUplodesDeletion($id)
    {
        $this->db->select('file_path');
        $this->db->from('uploads');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $file_path = $query->row()->file_path;
            if (file_exists($file_path)) {
                if (unlink($file_path)) {
                    
                    return true;
                }
            }
            return false; 
        } else {
            return false;
            
        }

    }
    public function AffiliationUplodesUpdate($fileUploadData,$id)
    {
        $data=[
            'file_name'=> $fileUploadData['file_name'],
            'file_path'=>$fileUploadData['full_path'],
            'file_extension' => $fileUploadData['file_ext'] ?? '',
            'uploaded_at' => date('Y-m-d H:i:s')
            
        ];
        $this->db->where('id', $id);
        return $this->db->update('uploads', $data);
    }

    public function checkUserEmailExists($email)
    {
        $query=$this->db->get_where('affiliation',['email'=>$email]);
        return $query->num_rows()>0;
    }

    public function checkCredentials($email,$password)
    {
        $query=$this->db->get_where('affiliation',['email'=>$email]);
        $query1=$query->row_array();
        if($query1['password']=='welcome ICVT@123')
        {
            return ($query1['password']==$password);
        }
        return password_verify($password,$query1['password']);

    }
    
    public function ChangePassword($email,$password)
    {
        $this->db->where('email',$email);
        return $this->db->update('affiliation',['password'=>$password]);

    }

    public function InstitutionLoginModel($email,$password)
    {
        $query = $this->db->get_where('affiliation', ['email' => $email]);
        $query1 = $query->row_array();
        if (!$query1) {
            return false;
        }
        if($query1['password']=='welcome ICVT@123')
        {
            return true;
        }
        return password_verify($password, $query1['password']);

    }

    public function editSectorStatusModel($id,$status)
    {
        $this->db->where('id', $id);
        $this->db->update('sector', ['status' => $status]);
        return $this->db->affected_rows() > 0;
    }

    public function getAllSector()
    {
        $query = $this->db->get('sector'); 
        return $query->result_array(); 
    }

    public function checkSectorExists($id)
    {
        $query=$this->db->get_where('sector',['id'=>$id]);
        return $query->num_rows()>0;
    }
    
    public function deleteSector($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('sector');
    }

    public function addCoursesModel($sectorId,$courseCode,$courseName)
    {
        $data=[
            'sector_id'=>$sectorId,
            'course_code'=>$courseCode,
            'courses'=>$courseName,
            'status'=>'active'
        ];
        return $this->db->insert('courses',$data);

    }

    public function editCourseStatusModel($id,$status)
    {
        $this->db->where('id', $id);
        $this->db->update('courses', ['status' => $status]);
        return $this->db->affected_rows() > 0;
    }
    public function getAllcourse()
    {
        $query = $this->db->get('courses'); 
        return $query->result_array(); 
    }

    public function checkCourseExists($id)
    {
        $query=$this->db->get_where('courses',['id'=>$id]);
        return $query->num_rows()>0;
    } 
    public function deleteCourse($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('courses');
    }
    


    



    
}
?>