<?php
class Crud_model extends CI_Model{
	
	function get_data_table($tbl, $value){
		$this->db->select($value);
		$this->db->from($tbl['table']);
		$this->db->where($tbl['id'], $tbl['kondisi']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_data($data){
	// die(var_dump($data));
	$query =$this->db->query("SELECT
								".$data['value']."
							FROM ".$data['table']."	
								".$data['join']." ");				
	return $query->result();
	
	}
	
	function simpan($tbl,$data){ 
		return $this->db->insert($tbl, $data); 
		// if($query){		
			// $pesan = array(
				// 'succes' => 'yes'
			// );
		// }else{
			// $errNo   = $this->db->_error_number();
			// $errMess = $this->db->_error_message();
			// $pesan = array(
				// 'succes' => 'no',
				// 'errNo' => $errNo,
				// 'errMess' => $errMess
			// );
		// }
		// echo json_encode($pesan);
	}
	
	function save_batch($tbl, $data){
		return $this->db->insert_batch($tbl, $data);  
	}
	
	function update_batch($tbl, $data, $kondisi){
		// die(var_dump($data));
		// for($i=0; $i<count($kondisi); $i++){
			return $this->db->update_batch($tbl, $data, $kondisi); 
		// }
	}
	
	function delete($table,$id){
		// die(var_dump($data));
		$this->db->where("id",$id);
		$this->db->delete($table);
	}
	
	function multi_delete($table, $id, $row){
		for($i=0; $i<count($table); $i++){
			$this->db->where($id[$i], $row);
			$this->db->delete($table[$i]);
		}
	}

	function update($tbl,$data){
		$this->db->where("id", $tbl['id']);
		$this->db->update($tbl['table'], $data);
		if($this->db->affected_rows() == 1){		
			$pesan = array(
				'succes' => 'yes'
			);
		}else{
			$pesan = "Not change";
		}
		echo json_encode($pesan);
	}
	
}
