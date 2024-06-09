<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login_model extends CI_Model
{
    //fungsi cek session
    function logged_id(){
        // return $this->session->userdata('user_id');
        return $this->session->userdata('hak_akses');
    }

    //fungsi check login
    function check_login($table, $field1, $field2){
		// die(var_dump($field1));
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('user', $field1['user']);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
}