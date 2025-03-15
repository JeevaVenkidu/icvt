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


    
}
?>