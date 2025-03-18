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
            'hall_ticket_path'=>base_url('uploads/HallTicket/' . $HallTicketUplodeData['file_name'])
        ];
        return $this->db->insert('student_hall_ticket',$data);
    }

    public function MultipleUploadHallTicket($fileName,$filePath)
    {
        $data=[
            'enrollment_number'=>$fileName,
            'hall_ticket_path'=>$filePath
        ];
        return $this->db->insert('student_hall_ticket',$data);
    }




}
?>