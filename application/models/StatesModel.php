<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatesModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function getAllStates() {
        $query = $this->db->get('states'); 
        return $query->result_array(); 
    }
    
}
?>