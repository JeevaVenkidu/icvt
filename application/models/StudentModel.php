<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }
    public function checkStudentExists($id)
    {
    $query = $this->db->get_where('student_info', ['id' => $id]);
    return $query->num_rows() > 0; // Returns TRUE if ID exists, FALSE otherwise
    }
    public function GetAllStudentModel()
    {
        $query = $this->db->get('student_info'); 
        return $query->result_array(); 
    }


}

?>
