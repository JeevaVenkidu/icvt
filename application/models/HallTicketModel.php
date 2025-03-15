<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class HallTicketModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }
    public function UploadHallTicketModel($EnrollmentNumber,$HallTicketUplodeData)
    {
        $data=[
            'enrollment_number'=>$EnrollmentNumber,
            'hall_ticket_path'=>$HallTicketUplodeData['full_path']
        ];
        return $this->db->insert('student_hall_ticket',$data);
    }


}
?>