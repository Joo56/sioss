<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class menu_model extends CI_Model
{
  
    function menu_user($field){
        $this->db->select('*');
        $this->db->from('user');
		// $this->db->join('user_menu', 'user_menu.id_user = user.id');
		// $this->db->join('mst_menu', 'mst_menu.id = user_menu.id');
        $this->db->where('user.id', $field);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
}