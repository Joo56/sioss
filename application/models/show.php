<?php
class show extends CI_Model{
	
	function stok_badge(){
		// BADGE STOK HABIS
			$this->db->select('kd_produk,nm_jns_produk,nm_produk,spesifikasi,stok,last_update');
			$this->db->where("stok ='0'");
			$this->db->group_start();
			$this->db->like('last_update', date('Y-m-d'));
			$this->db->group_end();
			$data = $this->db->get('vw_data_produk')->result();
		return $data;
	}
	
	function service_masuk(){
		// BADGE STOK HABIS
		$this->db->select('kd_service,nm_pelanggan,nm_perangkat,spesifikasi,tgl_penerimaan');
		$data = $this->db->get_where('vw_data_service', array('status_service' => 'PROSES'),5)->result();
		return $data;
	}
	
}
