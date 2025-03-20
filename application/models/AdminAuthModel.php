<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAuthModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

   /* public function AddAdminModel($username,$password)
    {
        $data=[
            'username'=>$username,
            'password'=>password_hash($password, PASSWORD_BCRYPT)
        ];
        return $this->db->insert('admin_credentials',$data);
    }*/
    public function AdminLoginModel($username,$password)
    {
        $query = $this->db->get_where('admin_credentials', ['username' => $username]);
        $query1 = $query->row_array();
        if (!$query1) {
            return false;
        }
        return password_verify($password, $query1['password']);
    }

}
?>