<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class dashboard extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('login_model');
		$this->load->library('datatables');
		$this->load->model('crud_model');
		$this->load->model('show');
		$this->load->library('fungzie');
		$this->load->library('session');
    } 
	 
	public function index(){
		$this->db->select('tgl_pengajuan_proyek');
		$this->db->order_by('id', 'DESC');
		$data['update_data'] = $this->db->get('data_proyek')->row();
		$data['kbli'] = $this->db->get('kbli2');
		
		$this->load->view('v_dashboard', $data );
	}
	
	public function dataoss(){	

		$i = 1;
		if(!empty($_POST['kbli'])){
			$this->db->where_in('KBLI', $_POST['kbli']);
		}
		if(!empty($_POST['risiko'])){
			$this->db->where('RISIKO_PROYEK', $_POST['risiko']);
		}
		$query = $this->db->get('rekap_data_ossrba');
		
		foreach($query->result_array() AS $row){
			$data[$i]['nib'] 				= $row['NIB'];
			$data[$i]['nama_perusahaan'] 	= strtoupper($row['NM_PERUSAHAAN']);
			$data[$i]['nama_proyek'] 		= strtoupper($row['nama_proyek']);
			$data[$i]['jenis_usaha'] 		= strtoupper($row['jenis_usaha']);
			$data[$i]['alamat'] 			= $row['ALAMAT_PERUSAHAAN'];
			$data[$i]['kbli'] 				= $row['KBLI'];
			$data[$i]['judul_kbli'] 		= $row['JUDUL_KBLI'];
			$data[$i]['risiko_proyek'] 		= $row['RISIKO_PROYEK'];
			$data[$i]['nama_dokumen'] 		= $row['NAMA_DOKUMEN'];
			$data[$i]['tgl_terbit_oss'] 	= $row['TGL_TERBIS_OSS'];
			$data[$i]['tgl_izin'] 			= $row['TGL_IZIN'];
			$data[$i]['status_respon'] 		= $row['status_respon'];
	
			$i++;
		} 
	 
		if(isset($data)){
			$out = array_values($data);	
		}else{
			$out ="";
		}
		echo json_encode($out);
	}
	
	public function upload(){
		// die(var_dump($_FILES[ 'data_proyek' ]));
		$excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(in_array ( $_FILES [ 'data_izin' ][ 'type' ], $excelMimes) &&  in_array ( $_FILES [ 'data_proyek' ][ 'type' ], $excelMimes )){
			$reader = new Xlsx(); 
			$spreadsheet = $reader->load($_FILES['data_izin']['tmp_name']); 
			$worksheet = $spreadsheet->getActiveSheet();  
			$worksheet_arr = $worksheet->toArray(); 
			
			$reader2 = new Xlsx(); 
			$spreadsheet2 = $reader2->load($_FILES['data_proyek']['tmp_name']); 
			$worksheet2 = $spreadsheet2->getActiveSheet();  
			$worksheet_arr2 = $worksheet2->toArray();
			
			// die(var_dump(count($worksheet_arr2[0]))); 

			if(count($worksheet_arr[0]) == 18 && count($worksheet_arr2[0]) == 28){		// MENGECEK JUMLAH KOLOM EXCEL
				$this->db->truncate('data_izin');
				$this->db->truncate('data_proyek');
				
				// Remove header row 
				unset($worksheet_arr[0]);
				
				foreach($worksheet_arr as $row){ 
				
				$tgl_izin = explode("/",$row[11]);
				$tgl_izin[2] = "20".$tgl_izin[2];
				// die(var_dump(implode("-",$tgl_izin)));	
					$data_izin = array(
						'id_permohonan_izin'     	=> $row[1],
						'nama_perusahaan'  			=> $row[2],
						'nib'  						=> $row[3],
						'tgl_terbit_oss'  			=> $row[4],
						'status_penanaman_modal' 	=> $row[5],
						'propinsi'  				=> $row[6],
						'kab_kota'  				=> $row[7],
						'id_proyek'  				=> $row[8],
						'kd_resiko'  				=> $row[9],
						'kbli'  					=> $row[10],
						'tgl_izin'  				=> implode("-",$tgl_izin),
						'uraian_jenis_perizinan' 	=> $row[12],
						'nama_dokumen'  			=> $row[13],
						'uraian_kewenangan'  		=> $row[14],
						'status_respon'  			=> $row[15],
						'kewenangan'  				=> $row[16],
						'kl_sektor'  				=> $row[17]
					);
					$query = $this->db->insert('data_izin', $data_izin);
				}
			
				// Remove header row 
				unset($worksheet_arr2[0]);

				foreach($worksheet_arr2 as $row){
					$data_proyek = array(
						'id_proyek'     			=> $row[1],
						'uraian_jns_proyek'  		=> $row[2],
						'nib'  						=> $row[3],
						'nama_perusahaan'  			=> $row[4],
						'tanggal_terbit_oss' 		=> str_replace("/","-",$row[5]),
						'status_penanaman_modal'  	=> $row[6],
						'jenis_usaha'  				=> $row[7],
						'risiko_proyek'  			=> $row[8],
						'nama_proyek'  				=> $row[9],
						'skala_usaha'  				=> $row[10],
						'alamat_usaha'  			=> $row[11],
						'kab_kota_usaha' 			=> $row[12],
						'kecamatan_usaha'  			=> $row[13],
						'kelurahan_usaha'  			=> $row[14],
						'longitude'  				=> $row[15],
						'latitude'  				=> $row[16],
						'tgl_pengajuan_proyek'  	=> $row[17],
						'kbli'  					=> $row[18],
						'judul_kbli'  				=> $row[19],
						'kl_sektor_pembina'  		=> $row[20],
						'nama_user'  				=> $row[21],
						'email'  					=> $row[22],
						'nomor_telp'  				=> $row[23],
						'luas_tanah'  				=> $row[24],
						'satuan_tanah'  			=> $row[25],
						'jumlah_investasi'  		=> $row[26],
						'TKI'  						=> $row[27]	
					);
					$query2 = $this->db->insert('data_proyek', $data_proyek);
					if($query && $query2){
						$pesan['succes'] = true;
					}else{
						$pesan['succes'] = false;
						$pesan['pesan'] = 'Data gagal disimpan';
					}
				}
			}else{
				$pesan['succes'] = false;
				$pesan['pesan'] = 'Data Excel Tidak Cocok';
			}		
		}else{
			$pesan['succes'] = false;
			$pesan['pesan'] = 'Data Type Tidak Didukung';
		}

		echo json_encode($pesan);	
	}

}
