<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InstitutionManagementModel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }
    public function GetInstitution($id){
        $query = $this->db->get_where('affiliation', ['id' => $id]); 
        return $query->row_array(); // Return single record as array
    }
    public function GetAllInstitution()
    {
        $query = $this->db->get('affiliation'); 
        return $query->result_array(); 
    }
    public function checkInstitutionExists($id)
    {
        $query = $this->db->get_where('affiliation', ['id' => $id]);
        return $query->num_rows() > 0; // Returns TRUE if ID exists, FALSE otherwise
    }
    public function updateInstitution($update_data,$id){
        $this->db->where('id', $id);
        $this->db->update('affiliation', $update_data);
        return $this->db->affected_rows() > 0;

    }
    public function deleteInstitutionModel($id){
        return $this->db->where('id',$id)->delete('affiliation');
    }
    
}

?>